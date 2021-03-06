<?php

namespace YEntWeChat\Suite;

// Don't change the alias name please. I met the issue "name already in use"
// when used in Laravel project, not sure what is causing it, this is quick
// solution.
use YEntWeChat\Core\AccessToken as BaseAccessToken;

/**
 * Class AuthorizerAccessToken.
 *
 * AuthorizerAccessToken is responsible for the access token of the authorizer,
 * the complexity is that this access token also requires the refresh token
 * of the authorizer which is acquired by the open platform authorization
 * process.
 *
 * This completely overrides the original AccessToken.
 */
class AuthorizerAccessToken extends BaseAccessToken
{
    /**
     * @var \EntWeChat\Suite\Authorization
     */
    protected $authorization;

    /**
     * AuthorizerAccessToken constructor.
     *
     * @param string                         $corpId
     * @param \EntWeChat\Suite\Authorization $authorization
     */
    public function __construct($corpId, Authorization $authorization)
    {
        parent::__construct($corpId, null);

        $this->authorization = $authorization;
    }

    /**
     * Get token from WeChat API.
     *
     * @param bool $forceRefresh
     *
     * @return string
     */
    public function getToken($forceRefresh = false)
    {
        $cached = $this->authorization->getAuthorizerAccessToken();

        if ($forceRefresh || empty($cached)) {
            return $this->refreshToken();
        }

        return $cached;
    }

    /**
     * Refresh authorizer access token.
     *
     * @return string
     */
    protected function refreshToken()
    {
        $token = $this->authorization->getApi()
                                     ->getAuthorizerToken(
                                         $this->authorization->getAuthorizerCorpId(),
                                         $this->authorization->getAuthorizerPermanentCode()
                                     );

        $this->authorization->setAuthorizerAccessToken($token['access_token'], $token['expires_in'] - 1500);

        return $token['access_token'];
    }

    /**
     * Return the AuthorizerCorpId.
     *
     * @return string
     */
    public function getCorpId()
    {
        return $this->authorization->getAuthorizerCorpId();
    }
}
