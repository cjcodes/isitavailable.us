<?php

namespace IsItAvailable\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Guzzle\Http\Client;

use IsItAvailable\RoomBundle\Entity\Event;
use IsItAvailable\RoomBundle\Entity\Room;

class IndexController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array(

        );
    }

    private function getNextEvent(Room $room)
    {
        $client = new Client();
        $res = $client->get($room->getCalendarUrl())->send();
        $json = $res->json();

        $em = $this->getDoctrine()->getManager();

        foreach ($json['feed']['entry'] as $eventRaw) {
            $endTime = new \DateTime($eventRaw['gd$when'][0]['endTime']);

            if ($endTime < new \DateTime()) {
                continue;
            }

            $startTime = new \DateTime($eventRaw['gd$when'][0]['startTime']);

            foreach ($eventRaw['gd$who'] as $who) {
                if (strpos($who['rel'], 'organizer')) {
                    $owner = $who['valueString'];
                    break;
                }
            }

            $event = new Event();
            $event->setWho($owner);
            $event->setStartTime($startTime);
            $event->setEndTime($endTime);
            $event->setRoom($room);

            return $event;
        }

        return false;
    }

    /**
     * @Route("/status", name="status")
     */
    public function statusAction()
    {
        $rooms = $this->getRooms();
        array_walk($rooms, function (&$item, $key) {
            $item = $item->toArray();
        });

        return new JsonResponse($rooms);
    }

    /**
     * Get the rooms for return
     *
     * @return \Doctrine\Common\Collections\ArrayCollection The rooms
     */
    private function getRooms()
    {
        $rooms = $this->getDoctrine()->getManager()->getRepository('IsItAvailableRoomBundle:Room')
            ->findBy(array(), array('id' => 'asc'));

        foreach ($rooms as $room) {
            $this->updateNextEvent($room);
        }

        return $rooms;
    }

    private function updateNextEvent(Room $room)
    {
        $em = $this->getDoctrine()->getManager();

        if ($room->getNextEvent() && $room->getNextEvent()->getEndTime() < new \DateTime()) {
            $em->remove($room->getNextEvent());
            $em->flush();
            $room->setNextEvent(null);
        }

        if (!$room->getNextEvent()) {
            $nextEvent = $this->getNextEvent($room);
            $room->setNextEvent($nextEvent);

            $em->persist($nextEvent);
        }

        $em->flush();
    }

    /**
     * @Route("/test")
     */
    public function testAction()
    {
        $data = array(
            'test' => 'data',
        );

        $response = new JsonResponse();
        $response->setData($data);

        return $response;
    }
}
