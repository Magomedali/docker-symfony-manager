<?php
declare(strict_types=1);

namespace App\Security\OAuth;

use App\Model\User\UseCase\Network\Auth\Command;
use App\Model\User\UseCase\Network\Auth\Handler;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FacebookAuthenticator extends SocialAuthenticator
{

	private $urlGenerator;
	private $clientRegistry;
	private $handler;


	public function __construct(UrlGeneratorInterface $urlGenerator, ClientRegistry $clientRegistry, Handler $handler)
	{
		$this->clientRegistry = $clientRegistry;
		$this->urlGenerator = $urlGenerator;
		$this->handler = $handler;
	}


	public function supports(Request $request): bool
	{
		return $request->attributes->get('_route') === 'oauth.facebook_check';
	}


	public function getCredentials(Request $request)
	{
		return $this->fetchAccessToken($this->getFacebookClient());
	}


	public function getUser($credentials,UserProviderInterface $userProvider)
	{
		$facebookUser = $this->getFacebookClient()->fetchUserFromToken($credentials);

		$network = 'facebook';
		$id = $facebookUser->getId();
		$username = $network . ':' . $id;

		try {
			return $userProvider->loadUserByUsername($username);
		} catch (UsernameNotFoundException $e) {
			$this->handler->handle(new Command($network,$id));
			return $userProvider->loadUserByUsername($username);
		}
	}

	/**
     * @return FacebookClient
     */
    private function getFacebookClient()
    {
        return $this->clientRegistry->getClient('facebook_main');
	}


	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->urlGenerator->generate('home'));
    }


    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }


    /**
     * Called when authentication is needed, but it's not sent.
     * This redirects to the 'login'.
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}