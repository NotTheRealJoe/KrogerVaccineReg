How to use:

PHP >= 7.4 + cURL extension required.

Edit `run.php` and set the desired values in the configuration section at the top.

- `KROGER_DOMAIN`: the website domain that your store uses, the same way it is in your browser when you visit the website. If there is a `www.`, include it.
- `ZIP_CODE`: 5-digit zip to center the search around
- `RADIUS`: Distance in miles to search. The server seems to clamp any number greater than 20 down to 20.
- `DATE_RANGE_START` and `DATE_RANGE_END`: the dates to search within. Must be a [string that can be parsed by `DateTime`](https://www.php.net/manual/en/datetime.formats.php).

Run `php run.php` from the command-line or use `loop.sh` to have it run repeatedly.