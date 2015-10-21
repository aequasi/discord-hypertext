<?php
namespace Discord\Api;

class Message extends AbstractApi
{
    /*
     * {"content":"@mentioned-person hello","mentions":["their-id"],"tts":false}
     */
    public function create($channelId, $content, $mentions = [], $tts = 'false')
    {
        return $this->request('POST', 'channels/'.$channelId.'/messages', [
            'headers' => ['authorization' => $this->token],
            'json' => [
                'content' => $content,
                'mentions' => $mentions,
                'tts' => $tts
            ]
        ]);
    }

    public function delete($channelId, $messageId)
    {
        return $this->request('DELETE', 'channels/'.$channelId.'/messages/'.$messageId, [
            'headers' => ['authorization' => $this->token]
        ]);
    }

    /*
     * {"content":"@mentioned-person hello","mentions":["their-id"]}
     */
    public function edit($channelId, $messageId, $content, $mentions)
    {
        return $this->request('PATCH', 'channels/'.$channelId.'/messages/'.$messageId, [
            'headers' => ['authorization' => $this->token],
            'json' => [
                'content' => $content,
                'mentions' => $mentions
            ]
        ]);
    }

    public function get($channel, $limit = 50, $before = null)
    {
        $params = '?limit='.$limit;
        if(!is_null($before)) {
            $params .= '&before='.$before;
        }
        return $this->request('get', 'channels/'.$channel.'/messages'.$params, [
            'headers' => ['authorization' => $this->token]
        ]);
    }
}