<?php

namespace App\Filament\Actions;

use App\Actions\Inventory\UseInventoryForJobOrder;
use App\Actions\JobOrder\ApproveJobOrder;
use App\Actions\JobOrder\CancelJobOrder;
use App\Actions\JobOrder\ReadyForPickup;
use App\Actions\JobOrder\ReleaseDevice;
use App\Actions\JobOrder\ReopenJobOrder;
use App\Actions\JobOrder\RequestApproval;
use App\Actions\JobOrder\StartDiagnosis;
use App\Actions\JobOrder\StartRepair;
use App\Actions\JobOrder\StartTesting;
use App\Actions\JobOrder\WaitForParts;
use App\Actions\Payment\RecordPayment;
use App\Enums\Inventory\Category;
use App\Enums\JobOrder\Status;
use App\Enums\Payment\Method;
use App\Models\InventoryItem;
use App\Models\JobOrder;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class JobOrderActions
{
    public static function make(): ActionGroup
    {
        return ActionGroup::make([

            /*
            |--------------------------------------------------------------------------
            | General
            |--------------------------------------------------------------------------
            */

            EditAction::make(),

            /*
            |--------------------------------------------------------------------------
            | Diagnosis
            |--------------------------------------------------------------------------
            */

            Action::make('startDiagnosis')
                ->label('Start Diagnosis')
                ->icon('heroicon-o-magnifying-glass')
                ->color('warning')
                ->visible(
                    fn (JobOrder $record) =>
                        $record->status === Status::Received
                )
                ->requiresConfirmation()
                ->action(
                    fn (JobOrder $record) =>
                        app(StartDiagnosis::class)->handle($record)
                ),

            /*
            |--------------------------------------------------------------------------
            | Customer Approval
            |--------------------------------------------------------------------------
            */

            Action::make('requestApproval')
                ->label('Waiting for Approval')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('info')
                ->visible(
                    fn (JobOrder $record) =>
                        $record->status === Status::Diagnosing
                )
                ->requiresConfirmation()
                ->modalHeading('Request Customer Approval')
                ->modalDescription(
                    'This will mark the job order as waiting for customer approval.'
                )
                ->action(
                    fn (JobOrder $record) =>
                        app(RequestApproval::class)->handle($record)
                ),

            Action::make('approveJobOrder')
                ->label('Approve Job')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(
                    fn (JobOrder $record) =>
                        $record->status === Status::WaitingApproval
                )
                ->requiresConfirmation()
                ->modalHeading('Approve Job Order')
                ->modalDescription(
                    'This will approve all pending services for this job order.'
                )
                ->action(
                    fn (JobOrder $record) =>
                        app(ApproveJobOrder::class)->handle($record)
                ),

            /*
            |--------------------------------------------------------------------------
            | Parts / Repair
            |--------------------------------------------------------------------------
            */

            Action::make('waitingParts')
                ->label('Waiting for Parts')
                ->icon('heroicon-o-cube')
                ->color('gray')
                ->visible(
                    fn (JobOrder $record) =>
                        $record->status === Status::Approved
                )
                ->requiresConfirmation()
                ->modalHeading('Wait for Parts')
                ->modalDescription(
                    'This job order will be placed on hold while waiting for parts.'
                )
                ->action(
                    fn (JobOrder $record) =>
                        app(WaitForParts::class)->handle($record)
                ),

            Action::make('startRepair')
                ->label('Start Repair')
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('primary')
                ->visible(
                    fn (JobOrder $record) => in_array(
                        $record->status,
                        [
                            Status::Approved,
                            Status::WaitingParts,
                        ],
                        true,
                    )
                )
                ->requiresConfirmation()
                ->modalHeading('Start Repair')
                ->modalDescription(
                    'Start the repair work for this job order?'
                )
                ->action(
                    fn (JobOrder $record) =>
                        app(StartRepair::class)->handle($record)
                ),

            /*
            |--------------------------------------------------------------------------
            | Inventory / Parts
            |--------------------------------------------------------------------------
            */

            Action::make('addParts')
                ->label('Add Parts')
                ->icon('heroicon-o-wrench')
                ->color('warning')
                ->visible(
                    fn (JobOrder $record) => in_array(
                        $record->status,
                        [
                            Status::Repairing,
                            Status::WaitingParts,
                        ],
                        true,
                    )
                )
                ->schema([

                    Select::make('inventory_item_id')
                        ->label('Part')
                        ->searchable()
                        ->preload()
                        ->options(function () {
                            return InventoryItem::query()
                                ->where('active', true)
                                ->where('quantity', '>', 0)
                                ->where(
                                    'category',
                                    Category::Consumable
                                )
                                ->orderBy('name')
                                ->get()
                                ->mapWithKeys(
                                    fn (InventoryItem $item) => [
                                        $item->id => sprintf(
                                            '%s (%d %s available)',
                                            $item->name,
                                            $item->quantity,
                                            $item->unit->value,
                                        ),
                                    ]
                                );
                        })
                        ->required(),

                    TextInput::make('quantity')
                        ->label('Quantity')
                        ->numeric()
                        ->integer()
                        ->minValue(1)
                        ->default(1)
                        ->required(),

                    Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3),

                ])
                ->action(
                    function (
                        JobOrder $record,
                        array $data
                    ) {
                        app(
                            UseInventoryForJobOrder::class
                        )->handle(
                            jobOrder: $record,
                            item: InventoryItem::findOrFail(
                                $data['inventory_item_id']
                            ),
                            quantity: (int) $data['quantity'],
                            notes: $data['notes'] ?? null,
                        );
                    }
                )
                ->successNotificationTitle(
                    'Part added successfully.'
                ),

            /*
            |--------------------------------------------------------------------------
            | Testing
            |--------------------------------------------------------------------------
            */

            Action::make('startTesting')
                ->label('Start Testing')
                ->icon('heroicon-o-beaker')
                ->color('warning')
                ->visible(
                    fn (JobOrder $record) =>
                        $record->status === Status::Repairing
                )
                ->requiresConfirmation()
                ->modalHeading('Start Testing')
                ->modalDescription(
                    'Start testing the repaired device?'
                )
                ->action(
                    fn (JobOrder $record) =>
                        app(StartTesting::class)->handle($record)
                ),

            /*
            |--------------------------------------------------------------------------
            | Ready for Pickup
            |--------------------------------------------------------------------------
            */

            Action::make('readyForPickup')
                ->label('Ready for Pickup')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(
                    fn (JobOrder $record) =>
                        $record->status === Status::Testing
                )
                ->requiresConfirmation()
                ->modalHeading('Ready for Pickup')
                ->modalDescription(
                    'Mark this job order as ready for customer pickup?'
                )
                ->action(
                    fn (JobOrder $record) =>
                        app(ReadyForPickup::class)->handle($record)
                ),

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            Action::make('recordPayment')
                ->label('Record Payment')
                ->icon('heroicon-o-currency-dollar')
                ->color('success')
                ->visible(
                    fn (JobOrder $record) =>
                        $record->status === Status::ReadyForPickup
                        && ! $record->isFullyPaid()
                )
                ->schema([

                    TextInput::make('amount')
                        ->label('Amount')
                        ->numeric()
                        ->default(
                            fn (JobOrder $record) =>
                                $record->balanceDue()
                        )
                        ->minValue(0.01)
                        ->required(),

                    Select::make('method')
                        ->label('Payment Method')
                        ->options(Method::array())
                        ->required(),

                    TextInput::make('reference')
                        ->label('Reference')
                        ->maxLength(255),

                    Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3),

                ])
                ->action(
                    function (
                        JobOrder $record,
                        array $data
                    ) {
                        app(RecordPayment::class)->handle(
                            $record,
                            (float) $data['amount'],
                            $data['method'],
                            $data['reference'] ?? null,
                            $data['notes'] ?? null,
                        );
                    }
                ),

            /*
            |--------------------------------------------------------------------------
            | Release Device
            |--------------------------------------------------------------------------
            */

            Action::make('releaseDevice')
                ->label('Release Device')
                ->icon('heroicon-o-hand-thumb-up')
                ->color('success')
                ->visible(
                    fn (JobOrder $record) =>
                        $record->status === Status::ReadyForPickup
                )
                ->requiresConfirmation()
                ->schema([

                    Section::make('Payment Summary')
                        ->visible(
                            fn (JobOrder $record) =>
                                ! $record->isFullyPaid()
                        )
                        ->schema([

                            TextInput::make('estimate')
                                ->label('Estimated Total')
                                ->default(
                                    fn (JobOrder $record) =>
                                        '₱' . number_format(
                                            (float) $record->estimate_total,
                                            2
                                        )
                                )
                                ->disabled()
                                ->dehydrated(false),

                            TextInput::make('paid')
                                ->label('Paid')
                                ->default(
                                    fn (JobOrder $record) =>
                                        '₱' . number_format(
                                            (float) $record->paid_total,
                                            2
                                        )
                                )
                                ->disabled()
                                ->dehydrated(false),

                            TextInput::make('balance')
                                ->label('Outstanding Balance')
                                ->default(
                                    fn (JobOrder $record) =>
                                        '₱' . number_format(
                                            $record->balanceDue(),
                                            2
                                        )
                                )
                                ->disabled()
                                ->dehydrated(false),

                        ]),

                    Textarea::make('reason')
                        ->label(
                            'Reason for releasing with outstanding balance'
                        )
                        ->rows(4)
                        ->visible(
                            fn (JobOrder $record) =>
                                ! $record->isFullyPaid()
                        )
                        ->required(
                            fn (JobOrder $record) =>
                                ! $record->isFullyPaid()
                        ),

                ])
                ->action(
                    function (
                        JobOrder $record,
                        array $data
                    ) {
                        app(ReleaseDevice::class)->handle(
                            $record,
                            auth()->user(),
                            $data['reason'] ?? null,
                        );
                    }
                ),

            /*
            |--------------------------------------------------------------------------
            | Cancel
            |--------------------------------------------------------------------------
            */

            Action::make('cancel')
                ->label('Cancel Job')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(
                    fn (JobOrder $record) => ! in_array(
                        $record->status,
                        [
                            Status::Released,
                            Status::Cancelled,
                        ],
                        true,
                    )
                )
                ->requiresConfirmation()
                ->modalHeading('Cancel Job Order')
                ->modalDescription(
                    'Are you sure you want to cancel this job order?'
                )
                ->action(
                    fn (JobOrder $record) =>
                        app(CancelJobOrder::class)->handle($record)
                ),

            /*
            |--------------------------------------------------------------------------
            | Reopen
            |--------------------------------------------------------------------------
            */

            Action::make('reopen')
                ->label('Reopen Job')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->visible(
                    fn (JobOrder $record) =>
                        $record->status === Status::Cancelled
                )
                ->requiresConfirmation()
                ->modalHeading('Reopen Job Order')
                ->modalDescription(
                    'Are you sure you want to reopen this job order?'
                )
                ->action(
                    fn (JobOrder $record) =>
                        app(ReopenJobOrder::class)->handle($record)
                ),

            /*
            |--------------------------------------------------------------------------
            | Print
            |--------------------------------------------------------------------------
            */

            Action::make('printReceipt')
                ->label('Print JO')
                ->icon('heroicon-o-printer')
                ->url(
                    fn (JobOrder $record) =>
                        route(
                            'job-orders.receipt',
                            ['jobOrder' => $record]
                        )
                )
                ->openUrlInNewTab(),

        ]);
    }
}