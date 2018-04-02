=== Able Player for WordPress ===
Tags: accessibility, accessible, multimedia, video, audio, movie, sound, film, ADA, WCAG, 508, able, player
Requires at least: 0.71
Contributors: darmentrout
Tested up to: 4.8
License: GPLv2 or later
Stable tag: trunk
License URI: http://www.gnu.org/licenses/license-list.html#GPLCompatibleLicenses

Make media accessible to all of your site's visitors with an easy-to-use shortcode.

== Description ==
## Able Player for WordPress

[Able Player](https://github.com/ableplayer/ableplayer) is a fully accessible cross-browser HTML5 media player. With an easy to use shortcode, this plugin gives you the ability to include audio or video wrapped in an accessible player in any post or page. This will enhance the user experience of visitors who rely on screen readers and keyboards (or other non-mouse input devices).

**Example Video:**

	// video only
	[able_player src="https://example.afk/sample.mp4"]

	// video with captions and chapters
	[able_player src="https://example.afk/sample.mp4" captions="https://example.afk/caps.vtt" chapters="https://example.afk/chaps.vtt"]


**Example Audio:**

	[able_player src="https://example.afk/sample.wav"]

	[able_player src="https://example.afk/sample.ogg" ogg_type="audio"]


The following file types are currently supported by Able Player:

**Video**: webm, webmv, mp4, ogg, ogv

**Audio**: mp3, ogg, oga, wav

*Note:* `Ogg` requires the inclusion of an additional parameter/attribute in the shortcode: `ogg_type = [audio|video]`.

____

Damion Armentrout, © 2017 ([GPLv2 License](http://www.gnu.org/licenses/license-list.html#GPLCompatibleLicenses) or later).


Able Player is © 2014 University of Washington (MIT License). The author of this plugin is not associated with Able Player or UW.

== Screenshots ==
1. Example: A movie and an audio file.
