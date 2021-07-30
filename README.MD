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

   Fox example:

   HTML:
   ```html
   <div id="online-masses">
      [section]
         [title text="THÁNH LỄ SẮP DIỄN RA" tag_name="h2" color="rgb(186, 74, 52)" class="bottom-border-highlight"]
         [online_masses_streaming_or_upcoming]
      [/section]

      [section]
         [title text="XEM LẠI THÁNH LỄ TRƯỚC" tag_name="h2" color="rgb(186, 74, 52)"]
         [online_masses_streamed]
      [/section]
   </div>
   ```

   CSS:
   ```css
   div#online-masses .header-nav .icon-inner {
      text-align: center;
   }

   div#online-masses .header-nav .icon-inner img {
      width: 80px;
   }

   div#online-masses .header-nav .icon-box-text {
      margin-top: -10px;
   }

   div#online-masses .mass-upcomming iframe {
      width: 100%;
      height: 46.25vw;
      margin-bottom: 20px;
      max-width: 1110px;
      max-height: 620px;
   }

   div#online-masses .mass-upcomming .title {
      background-color: #b84933;
      color: white;
      padding: 7px 15px;
      font-size: 17px;
   }

   div#online-masses .section-title-normal span {
      margin-right: 15px;
      padding-bottom: 7.5px;
      border-bottom: 2px solid rgb(186, 74, 52);
      margin-bottom: -2px;
   }

   div#online-masses .mass-streamed > .row {
      margin: 0 !important;
   }

   div#online-masses .mass-streamed > .row > .col {
      padding: 15px !important;
   }

   div#online-masses .mass-streamed iframe {
      width: 100%;
      height: 23vw;
      margin-bottom: 0px;
      max-height: 290px;
   }

   @media (max-width: 575px) {
      div#online-masses .mass-streamed iframe {
         height: 50vw;
      }
   }

   @media (min-width: 576px) {
      div#online-masses .header-nav {
         margin-top: -80px;
      }
   }

   @media (min-width: 768px) {
   }

   @media (min-width: 992px) {
   }

   @media (min-width: 1200px) {
   }
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

