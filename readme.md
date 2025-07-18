# YouTube Controlled Completion for LifterLMS

A WordPress plugin that allows you to force a YouTube video to be fully watched before the **Mark Complete** button is enabled in LifterLMS lessons.  
After viewing, it saves the information locally so the button doesn't disappear upon refresh.

## 📦 Instalation

1. Copy the plugin file (`youtube-controlled-completion.php`) to the directory: `/wp-content/plugins/youtube-controlled-completion/`
2. In your WordPress dashboard, go to **Plugins** and activate:
**YouTube Controlled Completion for LifterLMS**

## 🛠️ Usage

In any lesson, add the following shortcode to the lesson content:

```
[yt_complete_video video_id="FILM_ID" width="800" height="450"]
```
Example
```
[yt_complete_video video_id="dQw4w9WgXcQ"]
```
You can also force the player controls to be shown, e.g., for testing purposes:

```
[yt_complete_video video_id="dQw4w9WgXcQ" controls="1"]
```

Parameters:
- `video_id` (required) – the YouTube video ID.
- `width` (optional) – the video width (default: 100%).
- `height` (optional) – the video height (default: 480%).

## ⚙️ How it works

- The **Mark Complete** button (`#llms_mark_complete`) will be automatically **hidden**.
- After watching the video completely, the button will appear, allowing you to mark the lesson as complete.

## ℹ️ Note

- This feature only works in lessons where the `[yt_complete_video]` shortcode has been added.
- Supports one video per lesson.
