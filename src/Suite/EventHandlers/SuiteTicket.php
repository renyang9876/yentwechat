<?php

namespace YEntWeChat\Suite\EventHandlers;

use YEntWeChat\Suite\Ticket;

class SuiteTicket extends EventHandler
{
    /**
     * VerifyTicket.
     *
     * @var \EntWeChat\Suite\Ticket
     */
    protected $ticket;

    /**
     * Constructor.
     *
     * @param \EntWeChat\Suite\Ticket $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * {@inheritdoc}.
     */
    public function handle($message)
    {
        $this->ticket->setTicket($message->get('SuiteTicket'));
    }
}
