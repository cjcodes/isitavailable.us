<?php

namespace IsItAvailable\RoomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use IsItAvailable\RoomBundle\Entity\Room;

/**
 * Room update controller.
 *
 * @Route("/update", options={"expose": true})
 */
class RoomStatusController extends Controller
{
    /**
     * Update the status of a room
     *
     * @Route("/{room}/{status}")
     *
     * @param  Room    $room    The room to be updated
     * @param  Request $request The request object
     *
     * @return Response A response object containing the new status
     */
    public function updateAction(Room $room, $status, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $room->setStatus($status);

        $em->persist($room);
        $em->flush();

        return new Response($room->getStatus());
    }
}
