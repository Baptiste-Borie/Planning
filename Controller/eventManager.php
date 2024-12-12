<?php
class EventManager
{
    private $db;
    private $eventCollection;

    public function __construct($db)
    {
        require_once('./Model/Event.php');
        $this->db = $db;
        $this->eventCollection = "Planning.event";
    }

    public function getEvents()
    {
        $query = new MongoDB\Driver\Query([]); // Récupérer tous les événements
        $cursor = $this->db->executeQuery($this->eventCollection, $query);

        $events = [];
        foreach ($cursor as $event) {
            $events[] = (array) $event; // Convertir chaque événement en tableau associatif
        }

        return $events;
    }

    public function checkEventYear(array $events)
    {
        $groupedEvents = [];

        // Grouper les événements par année
        foreach ($events as $eventData) {
            $event = new Event($eventData);
            $year = $event->getYear();
            $weekNumber = $event->getWeekNumber();

            if (!isset($groupedEvents[$year])) {
                $groupedEvents[$year] = [];
            }

            $groupedEvents[$year][$weekNumber] = $event;
        }

        foreach ($groupedEvents as $year => $weeks) {
            $totalWeeks = (new DateTime())->setISODate($year, 53)->format('W') === '53' ? 53 : 52;

            for ($week = 1; $week <= $totalWeeks; $week++) {
                if (!isset($weeks[$week])) {
                    $this->addMissingEvent($year, $week);
                }
            }
        }
    }

    private function addMissingEvent(int $year, int $weekNumber)
    {
        $missingEvent = [
            '_id' => new MongoDB\BSON\ObjectId(),
            'year' => $year,
            'user_id' => null,
            'weekNumber' => $weekNumber
        ];

        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->insert($missingEvent);
        $this->db->executeBulkWrite($this->eventCollection, $bulk);
    }
}
