<?php

/*
 * This file is part of cleanse/discord-hypertext package.
 *
 * (c) 2015-2015 Paul Lovato <plovato@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Discord\Api;

use Discord\Api\Guild\Bans;
use Discord\Api\Guild\Channels;
use Discord\Api\Guild\Invites;
use Discord\Api\Guild\Members;
use Discord\Api\Guild\Roles;

class Guild extends AbstractApi
{
    public function create($name, $region)
    {
        return $this->request('POST', 'guilds', [
            'json' => [
                'name' => $name,
                'region' => $region
            ]
        ]);
    }

    public function leave($guildId)
    {
        return $this->request('DELETE', 'guilds/' . $guildId);
    }

    /*
     * {name: <string, required>, afk_channel_id: <id>, region: <region_name>, icon: <url_path/file_path>} are all you can change?
     */
    public function edit($guildId, $array = [])
    {
        $guild = $this->show($guildId);
        $json['name'] = isset($array['name']) ? $array['name'] : $guild['name'];
        $json['region'] = isset($array['region']) ? $array['region'] : $guild['region'];
        $json['icon'] = isset($array['icon']) ? $this->encodeIcon($array['icon']) : $guild['icon'];
        $json['afk_channel_id'] = isset($array['afk_channel_id']) ? $array['afk_channel_id'] : $guild['afk_channel_id'];

        return $this->request('PATCH', 'guilds/' . $guildId, [
            'json' => $json
        ]);
    }

    private function encodeIcon($image)
    {
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    /*
     * {enabled: <boolean>, channel_id: <id>}
     */
    public function toggleWidget($guildId, $enabled, $channelId = '')
    {
        return $this->request('PATCH', 'guilds/' . $guildId . '/embed', [
            'json' => [
                'channel_id' => $channelId,
                'enabled' => $enabled
            ]
        ]);
    }

    public function view($guildId)
    {
        return $this->request('GET', 'guilds/' . $guildId);
    }

    public function icon($guildId)
    {
        $guild = $this->show($guildId);

        return 'https://discordapp.com/api/guilds/' . $guildId . '/icons/' . $guild['icon'] . '.jpg';
    }

    public function channels()
    {
        return new Channels($this->client);
    }

    public function roles()
    {
        return new Roles($this->client);
    }

    public function members()
    {
        return new Members($this->client);
    }

    public function bans()
    {
        return new Bans($this->client);
    }

    public function invites()
    {
        return new Invites($this->client);
    }
}