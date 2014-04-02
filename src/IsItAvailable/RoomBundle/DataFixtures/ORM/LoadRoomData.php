<?php

namespace IsItAvailable\RoomBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IsItAvailable\RoomBundle\Entity\Room;

class LoadRoomData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $rooms = array(
            'Phone Booth 1' => array(
                'statusUrl'   => 'http://isitavailable.dev/app_dev.php/test',
                'calendarUrl' => 'http://www.google.com/calendar/feeds/dosomething.org_32343432363339332d3434%40resource.calendar.google.com/private-3c0b3b0ec8fdf4113dfcce78a413c3f7/full?alt=json',
            ),
            'Phone Booth 2' => array(
                'statusUrl'   => 'http://isitavailable.dev/app_dev.php/test',
                'calendarUrl' => 'http://www.google.com/calendar/feeds/dosomething.org_32353033383832362d3834%40resource.calendar.google.com/private-4cb70c2cea7f2a27a99b889b64cbc14f/full?alt=json',
            ),
        );

        foreach ($rooms as $name => $roomData) {
            $room = new Room();
            $room->setName($name);
            foreach ($roomData as $name => $field) {
                $name = 'set' . ucfirst($name);
                $room->$name($field);
            }

            $manager->persist($room);
        }

        $manager->flush();
    }
}