<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'question_1',
        'question_2',
        'question_3',
        'name',
        'email',
        'phone',
        'timeline',
        'message',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default status is pending
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Get the service that owns the inquiry
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the actual question text from service questions
     */
    public function getQuestionText($questionNumber)
    {
        $questions = $this->service->questions()->get();
        
        if ($questions->isEmpty()) {
            return "Question {$questionNumber}";
        }

        $index = $questionNumber - 1;
        return $questions->get($index)->question ?? "Question {$questionNumber}";
    }

    /**
     * Scope for pending inquiries
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for in progress inquiries
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope for completed inquiries
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Check if inquiry is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if inquiry is in progress
     */
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if inquiry is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}