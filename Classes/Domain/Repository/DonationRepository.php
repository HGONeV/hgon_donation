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

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
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
    public function findByFilter(array $filter = [], int $pageNumber = 1, int $limit = 3)
    {
        $query = $this->createQuery();

        // Offset
        $offset = max(0, ($pageNumber - 1) * $limit);

        // For offset issue on limit 1 (dein Spezialfall)
        if ($pageNumber > 1 && $limit === 1) {
            $offset = max(0, $offset - 1);
        }

        $constraints = [];

        // type
        if (!empty($filter['type'])) {
            $constraints[] = $query->equals('type', (int)$filter['type']);
        }

        // always: timeRangeEnd >= now OR timeRangeEnd = 0
        $constraints[] = $query->logicalOr(
            $query->greaterThanOrEqual('timeRangeEnd', time()),
            $query->equals('timeRangeEnd', 0)
        );

        // build query (WICHTIG: Array entpacken)
        if ($constraints !== []) {
            $query->matching($query->logicalAnd(...$constraints));
            // Alternative wäre: $query->matching($query->logicalAnd(...array_values($constraints)));
        }

        $query->setLimit($limit);
        $query->setOffset($offset);

        $query->setOrderings([
            'timeRangeStart' => QueryInterface::ORDER_ASCENDING,
        ]);

        return $query->execute();
    }



    /**
     * Find by DonationTxRkwprojectProject
     *
     * @param \HGON\HgonDonation\Domain\Model\Donation $donation
     * @param boolean $excludeGiven
     * @return array
     */
    public function findByDonationTxRkwprojectProject($donation, $excludeGiven = false)
    {
        $query = $this->createQuery();

        $constraints[] = $query->equals('txRkwprojectProject', $donation->getTxRkwprojectProject());

        if ($excludeGiven) {
            $constraints[] = $query->logicalNot($query->equals('uid', $donation));
        }

        $query->matching($query->logicalAnd($constraints));

        return $query->execute();
        //===
    }



    /**
     * find last created for newsletter
     *
     * @param int $limit
     * @return \Traversable
     */
    public function findLastCreated($limit = 2)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setLimit($limit);
        $query->setOrderings(
            array(
                'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
            )
        );
        return $query->execute();
        //===
    }

}
