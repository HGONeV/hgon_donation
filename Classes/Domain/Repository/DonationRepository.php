<?php
namespace HGON\HgonDonation\Domain\Repository;

/***
 *
 * This file is part of the "HGON Donation" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Maximilian Fäßler <maximilian@faesslerweb.de>, Fäßler Web UG
 *
 ***/
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * The repository for Donation
 */
class DonationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Get donations with certain options
     * -> If no parameter are given, we just have a findAll with offset and limit
     *
     * @param array $filter
     * @param integer $pageNumber
     * @param integer $limit
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByFilter($filter = [], $pageNumber = 1, $limit = 3)
    {
        $query = $this->createQuery();
        //$query->getQuerySettings()->setRespectStoragePage(false);

        // Offset
        //$offset = ((intval($pageNumber) - 1) * $limit) + 1;
        $offset = ((intval($pageNumber) - 1) * $limit);
        if ($pageNumber <= 1) {
            $offset = 0;
        }

        // For offset issue on limit 1
        if ($pageNumber > 1 && $limit == 1) {
            $offset -= 1;
        }

        $constraints = [];

        if ($filter['type']) {
            /*
            // type 1: time
            if ($filter['type'] == 1) {
                $constraints[] = $query->greaterThan('donationTypeTime', 0);
            }
            // type 2: money
            if ($filter['type'] == 2) {
                $constraints[] = $query->greaterThan('donationTypeMoney', 0);
            }
            */
            $constraints[] = $query->equals('type', $filter['type']);
        }

        /*
        if ($filter['time']) {
            $constraints[] =
            $query->logicalAnd(
                $query->lessThanOrEqual('timeRangeStart', intval($filter['time'])),
                $query->greaterThan('timeRangeStart', 0)
            );
        }
        */

        // always
        $constraints[] =
            $query->logicalOr(
                $query->greaterThanOrEqual('timeRangeEnd', time()),
                $query->equals('timeRangeEnd', 0)
            );

        // build query
        $query->matching($query->logicalAnd($constraints));

        $query->setLimit($limit);
        $query->setOffset($offset);

        $query->setOrderings(
            array(
                'timeRangeStart' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
            )
        );

        return $query->execute();
        //===

    }

}
