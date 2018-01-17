<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\UserBundle\Security\Guard;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor;

/**
 * Class JWTTokenAuthenticator.
 */
class JWTTokenAuthenticator extends BaseAuthenticator
{
    /**
     * @return TokenExtractor\TokenExtractorInterface
     */
    protected function getTokenExtractor()
    {
        // Or retrieve the chain token extractor for mapping/unmapping extractors for this authenticator
        /** @var TokenExtractor\ChainTokenExtractor $chainExtractor */
        $chainExtractor = parent::getTokenExtractor();

        // Add a new query parameter extractor to the configured ones
        $chainExtractor->addExtractor(
            new TokenExtractor\AuthorizationHeaderTokenExtractor(
                'Bearer',
                'Authorization'
            )
        );

        // Return the chain token extractor with the new map
        return $chainExtractor;
    }
}
