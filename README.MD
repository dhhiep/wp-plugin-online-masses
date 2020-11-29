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
3. Get video to display.

    ```php
    OnlineMass::streaming_or_upcoming_video(); # Get current video is streaming or upcomming
    OnlineMass::streamed_videos([number_of_videos]); # Get latest videos streamed
    ```

## Admin menu

This plugin also allow admin:

+ Create a Mass.
+ Edit a Mass, when admin edit a mass, the flag of this mass `allow_update` will be false, so the data can't override by cronjob fetch data from API anymore.
+ Delete a Mass.
+ Recovery a Mass (deleted).


## TODO
- [ ] Allow Admin create a Mass
- [ ] Allow Admin edit a Mass