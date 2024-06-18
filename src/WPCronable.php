<?php

namespace SebKay\WPCronable;

abstract class WPCronable
{
    protected string $wp_cron_name;

    protected int $wp_cron_interval = 300; // 5 minutes

    protected string|array $wp_cron_start = 'now';

    /**
     * @return int|false
     */
    protected function wpCronNextRun()
    {
        return \wp_next_scheduled($this->wp_cron_name);
    }

    public function getCronStart(): string
    {

        $interval = Helpers::getCronScheduleByTime($this->wp_cron_interval);

        if (! $interval) {
            return '';
        }

        if (\is_string($this->wp_cron_start)) {
            return "{$this->wp_cron_start} + {$interval['value']} seconds";
        }

        if (\is_array($this->wp_cron_start)) {
            $times = \array_map(function ($time) {
                return \strtotime($time);
            }, $this->wp_cron_start);

            $now = \strtotime('now');

            foreach ($times as $time) {
                if ($now < $time) {
                    return \date('Y-m-d H:i:s', $time);
                }
            }
        }

        return '';
    }

    public function scheduleCron(): void
    {
        \add_action($this->wp_cron_name, [$this, 'run']);

        if ($this->wpCronNextRun()) {
            return;
        }

        $interval = Helpers::getCronScheduleByTime($this->wp_cron_interval);

        if (! $interval) {
            return;
        }

        \wp_schedule_event(\strtotime($this->getCronStart()), $interval['slug'], $this->wp_cron_name);
    }

    public function unscheduleCron(): void
    {
        if (! $this->wpCronNextRun()) {
            return;
        }

        \wp_unschedule_event($this->wpCronNextRun(), $this->wp_cron_name);
    }
}
