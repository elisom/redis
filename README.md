# redis
Redis FIFO Queue for multi threads in PHP

When you get a lot of requests to the server but you want to process them one by one.

This code using Redis in PHP.
It creates internal redis database and hold the php process until is your turn in the process (FIFO)
