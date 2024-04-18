<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <div>
        <h2>Register a user</h2>
        <form action="/add_user" method="post">
            @csrf
            <input name="id" type="text" placeholder="id">
            <input name="auth_string" type="text" placeholder="authString">
            <input name="is_receiving_performance_notifications" type="text" placeholder="is_receiving_performance_notifications">
            <input name="is_receiving_news_notifications" type="text" placeholder="is_receiving_news_notifications">
            <button>add_user</button>
        </form>
    </div>
</html>