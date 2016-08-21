<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Portal\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\Ldap as LdapAdapter;
use Zend\Authentication\Storage\Session;
use Zend\Ldap\Ldap;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container as SessionContainer;
use Zend\View\Model\ViewModel;
use ZFT\User;

class IndexController extends AbstractActionController
{

    /** @var  User\Repository */
    private $userRepository;

    public function __construct(User\Repository $userRepository, SessionContainer $session) {
        $sessionStuff = $session->{'idont exist'};
        $this->userRepository = $userRepository;
    }

    public function indexAction()
    {

//        $options = [
//            'host' => 'dc-server.ad.alex-tech-adventures.com',
//            'username' => 'CN=sasha,DC=ad,DC=alex-tech-adventures,DC=com',
//            'password' => 'Anime2010',
//            'bindRequiresDn' => true,
//            'accountDomainName' => 'ad.alex-tech-adventures.com',
//            'baseDn'    => 'OU=Users,DC=ad,DC=alex-tech-adventures,DC=com',
//        ];

        $username = 'sasha';
        $password = 'Anime2010';

        $options = [
            'mainDC' => [
                'host' => 'dc-server.ad.alex-tech-adventures.com',
                'useStartTls' => true,
                'accountCanonicalForm' => Ldap::ACCTNAME_FORM_BACKSLASH,
//            'username' => $username,
//            'password' => $password,
                'accountDomainName' => 'ad.alex-tech-adventures.com',
                'accountDomainNameShort' => 'alex-tech',
                'baseDn'    => 'CN=Users,DC=ad,DC=alex-tech-adventures,DC=com',
            ],
//            'apacheDS' => [
//                'host' => 'apacheds.ad.alex-tech-adventures.com',
//                'port' => 10389,
//                'accountCanonicalForm' => Ldap::ACCTNAME_FORM_DN,
//                'accountDomainName' => 'ds.alex-tech-adventures.com',
//                'accountDomainNameShort' => 'alex-tech',
//                'baseDn'    => 'DC=ds,DC=alex-tech-adventures,DC=com',
//                'accountFilterFormat' => '(&(objectClass=person)(sn=%s))'
//            ]

        ];

        $adapter = new LdapAdapter($options, $username, $password);
        $auth = new AuthenticationService();
        $storage = $auth->getStorage();
        $hasIdentity = $auth->hasIdentity();
        $existingIdentity = $storage->read();

        $result = $auth->authenticate($adapter);

//        $adapter->getLdap();

        $messages = $result->getMessages();
        $isValid = $result->isValid();
        $identity = $result->getIdentity();

//        $ldap = new Ldap($options);
//        $acctname = $ldap->getCanonicalAccountName('sasha', Ldap::ACCTNAME_FORM_DN);

//        $user = new User();

//        $user = $this->userRepository->getUserById(5);

        return new ViewModel();
    }
}
