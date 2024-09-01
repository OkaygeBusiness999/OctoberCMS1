<?php namespace AppLogger\Logger\Models;

use Model;

/**
 * Log Model
 */
class Log extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'applogger_logger_logs';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['arrival_date', 'user_name', 'delay'];

    /**
     * Automatically determine log type based on arrival date and time.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($log) {
            // Define the thresholds
            $eightAM = new \DateTime('08:00:00');
            $arrivalTime = new \DateTime($log->arrival_date);
            $tenMinutesAfterEightAM = clone $eightAM;
            $tenMinutesAfterEightAM->modify('+10 minutes');
            $eightPM = new \DateTime('20:00:00');

            // Determine log type based on arrival time and delay
            if ($arrivalTime < $eightAM) {
                $log->log_type = 'early';
            } elseif ($arrivalTime > $eightPM) {
                $log->log_type = 'absent';
            } elseif ($arrivalTime >= $tenMinutesAfterEightAM || $log->delay > 10) {
                // Check if arrival time is after 08:10 AM or delay is more than 10 minutes
                $log->log_type = 'late';
            } else {
                $log->log_type = 'on time';
            }
        });
    }

    /**
     * @var array Validation rules
     */
    public $rules = [
        'arrival_date' => 'required|date',
        'user_name' => 'required|string',
        'delay' => 'required|integer',
    ];
}
