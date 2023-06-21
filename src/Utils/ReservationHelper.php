<?php

namespace Hetic\ReshomeApi\Utils;

use Hetic\ReshomeApi\Model\Entity\Announce;
use Hetic\ReshomeApi\Model\Entity\Reservation;
use Hetic\ReshomeApi\Model\Entity\User;
use Hetic\ReshomeApi\Model\Manager\ReservationManager;

class ReservationHelper
{
    public static function getReservationCost(string $beginDate, string $endDate, int $price): int
    {
        $startTimestamp = strtotime($beginDate);
        $endTimestamp = strtotime($endDate);

        $duration = ceil(($endTimestamp - $startTimestamp) / (60 * 60 * 24));

        return $duration * $price;
    }

    public static function isAvailable(int $announce_id, string $startDate, string $endDate): bool
    {
        $bookingDates = self::getBookingDatesByAnnounceId($announce_id);
        $availableDates = self::getAvailableDates($bookingDates, $startDate, $endDate);
        $requestedDates = self::getDatesFromPeriod($startDate, $endDate);

        return count($requestedDates) === count($availableDates);
    }

    private static function getAvailableDates(array $bookingDates, string $startDate, string $endDate): array
    {
        $availableDates = [];

        $currentDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        while ($currentDate <= $endDate) {
            $date = date('Y-m-d', $currentDate);

            if (!in_array($date, $bookingDates)) {
                $availableDates[] = $date;
            }

            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $availableDates;
    }

    private static function getBookingDatesByAnnounceId(int $announce_id): array
    {
        $manager = new ReservationManager();
        $bookings = $manager->getReservationsByAnnounceId($announce_id);
        $bookingDates = [];

        foreach ($bookings as $booking) {
            $startDate = $booking->getBeginDate();
            $endDate = $booking->getEndDate();

            $datesInRange = self::getDatesFromPeriod($startDate, $endDate);
            $bookingDates = array_merge($bookingDates, $datesInRange);
        }

        return $bookingDates;
    }

    public static function getDatesFromPeriod($startDate, $endDate) : array
    {
        $dates = array();

        $currentDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        while ($currentDate <= $endDate) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $dates;
    }

    public static function hasBookedThisAnnounce(User $user, Announce $announce) : int
    {
        $reservationManager = new ReservationManager();
        $userReservations = $reservationManager->getReservationsByUserAndAnnounceId($user->getUserId(), $announce->getAnnounceId());

        if (!$userReservations) {
            return 0;
        }
        return count($userReservations);
    }

    public static function isPassed(Reservation $reservation) : bool
    {
        $date = strtotime(date('Y-m-d'));
        if ($date >= strtotime($reservation->getEndDate())) {
            return true;
        }
        return false;
    }
}