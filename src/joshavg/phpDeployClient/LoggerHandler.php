<?php

namespace joshavg\phpDeployClient;

use Monolog\Handler\AbstractHandler;

class LoggerHandler extends AbstractHandler
{
    private $msgs = [];

    /**
     * Handles a record.
     *
     * All records may be passed to this method, and the handler should discard
     * those that it does not want to handle.
     *
     * The return value of this function controls the bubbling process of the handler stack.
     * Unless the bubbling is interrupted (by returning true), the Logger class will keep on
     * calling further handlers in the stack with a given log record.
     *
     * @param  array $record The record to handle
     * @return Boolean true means that this handler handled the record, and that bubbling is not permitted.
     *                        false means the record was either not processed or that this handler allows bubbling.
     */
    public function handle(array $record)
    {
        $msg = $record['message'];
        $lvl = $record['level_name'];
        /** @var $date \DateTime */
        $date = $record['datetime'];

        $this->msgs[] = $lvl . ' - ' . $date->format(\DateTime::ISO8601) . ': ' . $msg;

        // allow bubbling
        return false;
    }

    public function summarize()
    {
        return implode("\n", $this->msgs) . "\n";
    }
}
