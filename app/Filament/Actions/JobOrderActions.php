<?php

namespace App\Filament\Actions;

use App\Actions\JobOrder\CancelJobOrder;
use App\Actions\JobOrder\ReadyForPickup;
use App\Actions\JobOrder\ReleaseDevice;
use App\Actions\JobOrder\ReopenJobOrder;
use App\Actions\JobOrder\RequestApproval;
use App\Actions\JobOrder\StartDiagnosis;
use App\Actions\JobOrder\StartRepair;
use App\Actions\JobOrder\StartTesting;
use App\Actions\JobOrder\WaitForParts;
use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Illuminate\Support\HtmlString;

class JobOrderActions
{
    public static function make(): ActionGroup
    {
        return ActionGroup::make([

            EditAction::make(),

            Action::make('startDiagnosis')
                ->label('Start Diagnosis')
                ->icon('heroicon-o-magnifying-glass')
                ->color('warning')
                ->visible(fn (JobOrder $record) => $record->status === Status::Received)
                ->requiresConfirmation()
                ->action(fn (JobOrder $record) => app(StartDiagnosis::class)->handle($record)),

            Action::make('requestApproval')
                ->label('Waiting for Approval')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('info')
                ->visible(fn (JobOrder $record) => $record->status === Status::Diagnosing)
                ->requiresConfirmation()
                ->action(fn (JobOrder $record) => app(RequestApproval::class)->handle($record)),

            Action::make('waitingParts')
                ->label('Waiting for Parts')
                ->icon('heroicon-o-cube')
                ->color('gray')
                ->visible(fn (JobOrder $record) => in_array(
                    $record->status,
                    [
                        Status::Diagnosing,
                        Status::WaitingApproval,
                    ],
                    true,
                ))
                ->requiresConfirmation()
                ->action(fn (JobOrder $record) => app(WaitForParts::class)->handle($record)),

            Action::make('startRepair')
                ->label('Start Repair')
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('primary')
                ->visible(fn (JobOrder $record) => in_array(
                    $record->status,
                    [
                        Status::Diagnosing,
                        Status::WaitingApproval,
                        Status::WaitingParts,
                    ],
                    true,
                ))
                ->requiresConfirmation()
                ->action(fn (JobOrder $record) => app(StartRepair::class)->handle($record)),

            Action::make('startTesting')
                ->label('Start Testing')
                ->icon('heroicon-o-beaker')
                ->color('warning')
                ->visible(fn (JobOrder $record) => $record->status === Status::Repairing)
                ->requiresConfirmation()
                ->action(fn (JobOrder $record) => app(StartTesting::class)->handle($record)),

            Action::make('readyForPickup')
                ->label('Ready for Pickup')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn (JobOrder $record) => $record->status === Status::Testing)
                ->requiresConfirmation()
                ->action(fn (JobOrder $record) => app(ReadyForPickup::class)->handle($record)),

            Action::make('releaseDevice')
                ->label('Release Device')
                ->icon('heroicon-o-hand-thumb-up')
                ->color('success')
                ->requiresConfirmation()
                ->schema([

                    Section::make('Payment Summary')
                        ->visible(fn (JobOrder $record) => ! $record->isFullyPaid())
                        ->schema([
                            TextInput::make('estimate')
                                ->label('Estimated Total')
                                ->default(fn (JobOrder $record) => '₱' . \number_format((float) $record->estimate_total, 2))
                                ->disabled()
                                ->dehydrated(false),

                            TextInput::make('paid')
                                ->label('Paid')
                                ->default(fn (JobOrder $record) => '₱' . \number_format((float) $record->paid_total, 2))
                                ->disabled()
                                ->dehydrated(false),

                            TextInput::make('balance')
                                ->label('Outstanding Balance')
                                ->default(fn (JobOrder $record) => '₱' . \number_format($record->balanceDue(), 2))
                                ->disabled()
                                ->dehydrated(false),
                        ]),

                    Textarea::make('reason')
                        ->label('Reason for releasing with outstanding balance')
                        ->rows(4)
                        ->visible(fn (JobOrder $record) => ! $record->isFullyPaid())
                        ->required(fn (JobOrder $record) => ! $record->isFullyPaid()),

                ]),

            Action::make('cancel')
                ->label('Cancel Job')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (JobOrder $record) => ! in_array(
                    $record->status,
                    [
                        Status::Released,
                        Status::Cancelled,
                    ],
                    true,
                ))
                ->requiresConfirmation()
                ->modalHeading('Cancel Job Order')
                ->modalDescription('Are you sure you want to cancel this job order?')
                ->action(fn (JobOrder $record) => app(CancelJobOrder::class)->handle($record)),

            Action::make('reopen')
                ->label('Reopen Job')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->visible(fn (JobOrder $record) => $record->status === Status::Cancelled)
                ->requiresConfirmation()
                ->action(fn (JobOrder $record) => app(ReopenJobOrder::class)->handle($record)),

        ]);
    }
}