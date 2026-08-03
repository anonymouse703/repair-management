<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentRoute;
use App\Models\DocumentLog;
use App\Enums\Document\Status;
use Illuminate\Support\Facades\DB;

class DocumentService
{
    /**
     * Create a document — field_office_id and current_department_id
     * come from the creating user's assignment.
     */
    public function create(array $data): Document
    {
        $user = auth()->user();

        $data['created_by']            = $user->id;
        $data['current_department_id'] = $user->dept_id;
        $data['field_office_id']       = $user->field_office_id;
        $data['status']                = Status::Draft;

        return Document::create($data);
    }

    /**
     * Forward a document to another department.
     * field_office_id on the document travels with it.
     */
    public function forward(
        Document $document,
        int $toDepartmentId,
        int $userId,
        ?string $remarks = null,
        bool $isFinal = false
    ) {
        return DB::transaction(function () use ($document, $toDepartmentId, $userId, $remarks, $isFinal) {

            // Resolve destination department and its field office
            $toDepartment    = Department::findOrFail($toDepartmentId);
            $toFieldOfficeId = $toDepartment->field_office_id;

            DocumentRoute::create([
                'document_id'        => $document->id,
                'from_department_id' => $document->current_department_id,
                'to_department_id'   => $toDepartmentId,
                'forwarded_by'       => $userId,
                'forwarded_at'       => now(),
                'remarks'            => $remarks,
                'is_final'           => $isFinal,
            ]);

            $document->update([
                'current_department_id' => $toDepartmentId,
                'field_office_id'       => $toFieldOfficeId, // ← travels with doc
                'status'                => Status::InTransit,
                'last_moved_at'         => now(),
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id'     => $userId,
                'action'      => 'forwarded',
                'description' => "Forwarded to {$toDepartment->name}" . ($isFinal ? " (final)" : ""),
            ]);
        });
    }

    /**
     * Receive a document in a department.
     */
    public function receive(Document $document, int $userId)
    {
        return DB::transaction(function () use ($document, $userId) {

            $route = $document->routes()
                ->where('to_department_id', auth()->user()->dept_id)
                ->whereNull('received_at')
                ->latest()
                ->firstOrFail();

            $route->update([
                'received_by' => $userId,
                'received_at' => now(),
            ]);

            $newStatus = $route->is_final ? Status::Completed : Status::Received;

            $document->update([
                'status'        => $newStatus,
                'received_at'   => now(),
                'last_moved_at' => now(),
                'completed_at'  => $route->is_final ? now() : null,
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id'     => $userId,
                'action'      => 'received',
                'description' => "Document received" . ($route->is_final ? " and completed" : ""),
            ]);
        });
    }

    /**
     * Cancel a document.
     */
    public function cancel(Document $document, int $userId, ?string $remarks = null)
    {
        return DB::transaction(function () use ($document, $userId, $remarks) {
            $document->update([
                'status'       => Status::Cancelled,
                'cancelled_at' => now(),
                'remarks'      => $remarks,
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id'     => $userId,
                'action'      => 'cancelled',
                'description' => "Document cancelled" . ($remarks ? ": {$remarks}" : ""),
            ]);
        });
    }

    /**
     * Reopen a completed document for further forwarding.
     */
    public function reopen(Document $document, int $userId)
    {
        return DB::transaction(function () use ($document, $userId) {

            if ($document->status !== Status::Completed) {
                throw new \Exception("Only completed documents can be reopened.");
            }

            $document->update([
                'status'       => Status::Reopened,
                'completed_at' => null,
            ]);

            $latestRoute = $document->routes()->latest()->first();
            if ($latestRoute) {
                $latestRoute->update(['is_final' => false]);
            }

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id'     => $userId,
                'action'      => 'reopened',
                'description' => "Document reopened for further forwarding.",
            ]);
        });
    }

    /**
     * Mark as final.
     */
    public function markAsFinal(Document $document, int $userId)
    {
        return DB::transaction(function () use ($document, $userId) {

            if (!in_array($document->status, [Status::Received, Status::Reopened])) {
                throw new \Exception("Only received or reopened documents can be marked as final.");
            }

            $latestRoute = $document->routes()->latest()->first();
            if ($latestRoute) {
                $latestRoute->update(['is_final' => true]);
            }

            $document->update([
                'status'       => Status::Completed,
                'completed_at' => now(),
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id'     => $userId,
                'action'      => 'marked_final',
                'description' => 'Document marked as final',
            ]);
        });
    }
}