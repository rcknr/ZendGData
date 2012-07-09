<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_GData
 */

namespace Zend\GData\GApps;

use Zend\GData\GApps;

/**
 * Assists in constructing queries for Google Apps member entries.
 * Instances of this class can be provided in many places where a URL is
 * required.
 *
 * For information on submitting queries to a server, see the Google Apps
 * service class, Zend\GData\GApps.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Gapps
 */
class MemberQuery extends AbstractQuery
{

    /**
     * If not null, specifies the group id
     *
     * @var string
     */
    protected $_groupId = null;

    /**
     * If not null, specifies the member id of the user who should be
     * retrieved by this query.
     *
     * @var string
     */
    protected $_memberId = null;

    /**
     * Create a new instance.
     *
     * @param string $domain (optional) The Google Apps-hosted domain to use
     *          when constructing query URIs.
     * @param string $groupId (optional) Value for the groupId property.
     * @param string $memberId (optional) Value for the memberId property.
     * @param string $startMemberId (optional) Value for the
     *          startMemberId property.
     */
    public function __construct($domain = null, $groupId = null, $memberId = null,
            $startMemberId = null)
    {
        parent::__construct($domain);
        $this->setGroupId($groupId);
        $this->setMemberId($memberId);
        $this->setStartMemberId($startMemberId);
    }

    /**
     * Set the group id to query for.
     *
     * @see getGroupId
     * @param string $value The group id to filter search results by, or null to
     *              disable.
     */
    public function setGroupId($value)
    {
        $this->_groupId = $value;
    }

    /**
     * Get the group id to query for. If no group id is set, null will be
     * returned.
     *
     * @param string $value The group id to filter search results by, or
     *          null if disabled.
     * @return string The group id
     */
    public function getGroupId()
    {
        return $this->_groupId;
    }


    /**
     * Set the member id to query for. When set, only users with a member id
     * matching this value will be returned in search results. Set to
     * null to disable filtering by member id.
     *
     * @see getMemberId
     * @param string $value The member id to filter search results by, or null to
     *              disable.
     */
    public function setMemberId($value)
    {
        $this->_memberId = $value;
    }

    /**
     * Get the member id to query for. If no member id is set, null will be
     * returned.
     *
     * @param string $value The member id to filter search results by, or
     *          null if disabled.
     * @return The member id
     */
    public function getMemberId()
    {
        return $this->_memberId;
    }

    /**
     * Set the first member id which should be displayed when retrieving
     * a list of members.
     *
     * @param string $value The first member id to be returned, or null to
     *          disable.
     */
    public function setStartMemberId($value)
    {
        if ($value !== null) {
            $this->_params['start'] = $value;
        } else {
            unset($this->_params['start']);
        }
    }

    /**
     * Get the first username which should be displayed when retrieving
     * a list of users.
     *
     * @see setStartUsername
     * @return string The first username to be returned, or null if
     *          disabled.
     */
    public function getStartMemberId()
    {
        if (array_key_exists('start', $this->_params)) {
            return $this->_params['start'];
        } else {
            return null;
        }
    }

    /**
     * Returns the query URL generated by this query instance.
     *
     * @return string The query URL for this instance.
     */
    public function getQueryUrl()
    {

        $uri = \Zend\GData\GApps::APPS_BASE_FEED_URI;
        $uri .= \Zend\GData\GApps::APPS_GROUP_PATH;
        $uri .= '/' . $this->_domain;
        if ($this->_groupId !== null) {
            $uri .= '/' . $this->_groupId;
        } else {
            throw new \Zend\GData\App\InvalidArgumentException(
                    'groupId must not be null');
        }

        $uri .= '/member';

        if ($this->_memberId !== null) {
            $uri .= '/' . $this->_memberId;
        }
        $uri .= $this->getQueryString();
        return $uri;
    }

}
