<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('public', function() {
    return true;
});

Broadcast::channel('private.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('presence.{groupId}', function($user, $groupId) {
    logger("authenticating .... ", [ "user_id" => $user->id , "group_id" => $groupId, "can_join" => $user->canJoinGroup($groupId)]);
    if ($user->canJoinGroup($groupId)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});
