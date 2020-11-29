# TGPSG Online Masses
TGPSG Online Masses is a solution to embedded online masses live stream from channel "TGPSG Thánh Lễ trực tuyến" automatically.

## Workflow
1. Fetch data from analytic API.

	This API will analyze Youtube channel `TGPSG Thánh Lễ trực tuyến` and output result as JSON format:

    ```json
    [
      {
      "timestamp": 1606645800,
      "id": "WJuzBR3oBPw",
      "url": "https://www.youtube.com/watch?v=WJuzBR3oBPw",
      "thumbnail": "https://i.ytimg.com/vi/WJuzBR3oBPw/hqdefault_live.jpg",
      "title": "Thánh Lễ trực tuyến ngày 29-11-2020: Chúa nhật 1 mùa Vọng năm B lúc 17:30",
      "event_type": "upcoming",
      "published_at": "2020-11-29 17:30:00 +0700",
      "ended_at": null
      },
      {
        "timestamp": 1606559373,
        "id": "ncpcSEryrcw",
        "url": "https://www.youtube.com/watch?v=ncpcSEryrcw",
        "thumbnail": "https://i.ytimg.com/vi/ncpcSEryrcw/hqdefault.jpg",
        "title": "Thánh Lễ trực tuyến ngày 28-11-2020: Chúa nhật 1 mùa Vọng năm B lúc 17:30",
        "event_type": "streamed",
        "published_at": "2020-11-28 17:29:33 +0700",
        "ended_at": "2020-11-28 18:23:34 +0700"
      }
    ]
    ```

   Repository: [https://github.com/dhhiep/tgpsg_thanh_le_online](https://github.com/dhhiep/tgpsg_thanh_le_online)

2. After fetch data from analytics API by cronjob, I will store them into database and using the `id` is primary key.

   + If the `id` is not exist I will create a new record.
   + If the `id` is existed and flag `allow_update` is true, I will update this record.
3. Using WP shortcode to embedded video to frontend.

    ```php
    [online_masses_streaming_or_upcoming] # Get current video is streaming or upcomming
    [online_masses_streamed] # Get latest videos streamed
    ```

## Admin menu

#### 1. Features
This plugin also allow admin:

+ Create a Mass.
+ Edit a Mass, when admin edit a mass, the flag of this mass `allow_update` will be false, so the data can't override by cronjob fetch data from API anymore.
+ Delete a Mass.
+ Recovery a Mass (deleted).
+ Embedded video by shortcodes.

#### 2. Create a cronjob to fetch new data every 15 minutes.

  1. Install `WP Crontrol`.
  2. After installed, we go to `Tools > Cron Events`
  3. At tab `Cron Schedules` create a new schedule

      ```
      Internal Name: Online Masses Fetcher
      Interval (seconds): 900
      Display name: Online Masses Fetcher
      ```
  4. Go to tab `Add PHP Cron Event` and create a new event

		_PHP Code:_
      ```php
      OnlineMass::fetch_all();
      ```
		_Another fields:_
      ```
      Event Name (optional): Online Masses Fetcher
      Next Run: Now
      Recurrence: Online Masses Fetcher
      ```

## TODO
- [ ] Allow Admin create a Mass
- [ ] Allow Admin edit a Mass