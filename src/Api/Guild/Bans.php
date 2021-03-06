<?php

/*
 * This file is part of cleanse/discord-hypertext package.
 *
 * (c) 2015-2015 Paul Lovato <plovato@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Discord\Api\Guild;

use Discord\Api\AbstractApi;

class Bans extends AbstractApi
{
    public function add($guildId, $memberId, $days = 1)
    {

        return $this->request('PUT', 'guilds/' . $guildId . '/bans/' . $memberId . '?delete-message-days=' . $days);
    }

    public function remove($guildId, $memberId)
    {
        return $this->request('DELETE', 'guilds/' . $guildId . '/bans/' . $memberId);
    }

    public function view($guildId)
    {
        return $this->request('GET', 'guilds/' . $guildId . '/bans');
    }
}