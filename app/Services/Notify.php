<?php

namespace  App\Services;

class Notify
{
    //Created Notifivation
    static function createdNotification()
    {
        return notyf()->addSuccess('Created Successfully ⚡️', 'Success!');
    }

    //Updated Notifivation
    static function updatedNotification()
    {
        return notyf()->addSuccess('Updated Successfully ⚡️', 'Success!');
    }

    static function deletedNotification()
    {
        return notyf()->addSuccess('Deleted Successfully ⚡️', 'Success!');
    }

    static function errorNotification(string $error)
    {
        return notyf()->addError($error, 'Error!');
    }

    static function successNotification(string $message)
    {
        return notyf()->addSuccess($message, 'Success!');
    }
}
