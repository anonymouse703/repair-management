<?php

namespace App\Filament\Actions;

use App\Actions\JobOrder\CancelJobOrder;
use App\Actions\JobOrder\ReadyForPickup;
use App\Actions\JobOrder\ReleaseDevice;
use App\Actions\JobOrder\RequestApproval;
use App\Actions\JobOrder\ReopenJobOrder;
use App\Actions\JobOrder\StartDiagnosis;
use App\Actions\JobOrder\StartRepair;
use App\Actions\JobOrder\StartTesting;
use App\Actions\JobOrder\WaitForParts;
use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;

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
                ->action(function (
                    JobOrder $record,
                    StartDiagnosis $action,
                ) {
                    $action->handle($record);
                }),

            Action::make('requestApproval')
                ->label('Waiting for Approval')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('info')
                ->visible(fn (JobOrder $record) => $record->status === Status::Diagnosing)
                ->requiresConfirmation()
                ->action(function (
                    JobOrder $record,
                    RequestApproval $action,
                ) {
                    $action->handle($record);
                }),

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
                ->action(function (
                    JobOrder $record,
                    WaitForParts $action,
                ) {
                    $action->handle($record);
                }),

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
                ->action(function (
                    JobOrder $record,
                    StartRepair $action,
                ) {
                    $action->handle($record);
                }),

            Action::make('startTesting')
                ->label('Start Testing')
                ->icon('heroicon-o-beaker')
                ->color('warning')
                ->visible(fn (JobOrder $record) => $record->status === Status::Repairing)
                ->requiresConfirmation()
                ->action(function (
                    JobOrder $record,
                    StartTesting $action,
                ) {
                    $action->handle($record);
                }),

            Action::make('readyForPickup')
                ->label('Ready for Pickup')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn (JobOrder $record) => $record->status === Status::Testing)
                ->requiresConfirmation()
                ->action(function (
                    JobOrder $record,
                    ReadyForPickup $action,
                ) {
                    $action->handle($record);
                }),

            Action::make('releaseDevice')
                ->label('Release Device')
                ->icon('heroicon-o-hand-thumb-up')
                ->color('success')
                ->visible(fn (JobOrder $record) => $record->status === Status::ReadyForPickup)
                ->requiresConfirmation()
                ->modalHeading('Release Device')
                ->modalDescription(fn (JobOrder $record) => $record->balanceDue() > 0
                    ? 'Warning! This job still has an outstanding balance of ₱'
                        . number_format($record->balanceDue(), 2)
                        . '. Are you sure you want to release the device?'
                    : 'Are you sure you want to release this device?')
                ->action(function (
                    JobOrder $record,
                    ReleaseDevice $action,
                ) {
                    $action->handle($record);
                }),

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
                ->action(function (
                    JobOrder $record,
                    CancelJobOrder $action,
                ) {
                    $action->handle($record);
                }),

            Action::make('reopen')
                ->label('Reopen Job')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->visible(fn (JobOrder $record) => $record->status === Status::Cancelled)
                ->requiresConfirmation()
                ->action(function (
                    JobOrder $record,
                    ReopenJobOrder $action,
                ) {
                    $action->handle($record);
                }),

        ]);
    }
}