<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Certificate</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    width: 841px;
    height: 595px;
    font-family: 'DejaVu Serif', serif;
    background: #fff;
  }
  .cert {
    width: 841px;
    height: 595px;
    position: relative;
    background: #fff;
  }
  .border-outer {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    border: 14px solid #0B1F3A;
  }
  .border-inner {
    position: absolute;
    top: 18px; left: 18px; right: 18px; bottom: 18px;
    border: 2px solid #D4AF37;
  }
  .content {
    position: absolute;
    top: 28px; left: 28px; right: 28px; bottom: 28px;
    text-align: center;
  }
  .org { font-size: 15px; font-weight: bold; color: #0B1F3A; letter-spacing: 4px; text-transform: uppercase; margin-top: 6px; }
  .org-sub { font-size: 7px; color: #888; letter-spacing: 2px; text-transform: uppercase; margin-top: 2px; }
  .divider { width: 40%; height: 1px; background: #D4AF37; margin: 5px auto; }
  .cert-title { font-size: 40px; font-weight: bold; color: #0B1F3A; letter-spacing: 8px; line-height: 1; margin-top: 2px; }
  .cert-of { font-size: 8px; letter-spacing: 3px; color: #888; text-transform: uppercase; margin-top: 2px; }
  .cert-type { font-size: 10px; color: #D4AF37; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; margin-top: 2px; }
  .presented { font-size: 8px; color: #666; margin-top: 10px; margin-bottom: 3px; }
  .student-name { font-size: 28px; color: #D4AF37; font-style: italic; font-weight: bold; line-height: 1.2; }
  .school { font-size: 8px; color: #555; letter-spacing: 1px; margin-top: 2px; }
  .achieve-text { font-size: 8px; color: #444; line-height: 1.5; margin: 5px auto 0; width: 480px; }
  .pills { margin-top: 8px; text-align: center; }
  .pill {
    border-radius: 20px;
    padding: 3px 12px;
    font-size: 7px;
    font-weight: bold;
    letter-spacing: 1px;
    margin: 0 2px;
    display: inline;
  }
  .pill-gold { background: #D4AF37; color: #0B1F3A; }
  .pill-dark { background: #0B1F3A; color: #fff; }
  .bottom {
    position: absolute;
    bottom: 30px;
    left: 30px;
    right: 30px;
    border-top: 1px solid #ddd;
    padding-top: 5px;
  }
  .bottom-left {
    position: absolute; left: 0; bottom: 0;
    text-align: left; font-size: 6.5px; color: #888; line-height: 1.8;
  }
  .bottom-center {
    position: absolute; left: 50%; bottom: 0;
    transform: translateX(-50%); text-align: center;
  }
  .sign-line { width: 75px; border-top: 1px solid #333; margin: 0 auto 2px; }
  .sign-label { font-size: 6.5px; font-weight: bold; letter-spacing: 1px; color: #444; text-transform: uppercase; }
  .sign-sub { font-size: 6px; color: #aaa; }
  .bottom-right {
    position: absolute; right: 0; bottom: 0;
    text-align: right; font-size: 6.5px; color: #888; line-height: 1.8;
  }
  .strong { color: #444; font-weight: bold; }
  .corner { position: absolute; font-size: 13px; color: #D4AF37; }
  .c-tl { top: 20px; left: 20px; }
  .c-tr { top: 20px; right: 20px; }
  .c-bl { bottom: 20px; left: 20px; }
  .c-br { bottom: 20px; right: 20px; }
</style>
</head>
<body>
<div class="cert">
  <div class="border-outer"></div>
  <div class="border-inner"></div>
  <span class="corner c-tl">&#10022;</span>
  <span class="corner c-tr">&#10022;</span>
  <span class="corner c-bl">&#10022;</span>
  <span class="corner c-br">&#10022;</span>

  <div class="content">
    <div class="org">Suman Tech</div>
    <div class="org-sub">Computer Education Center &mdash; Patna, Bihar</div>
    <div class="divider"></div>
    <div class="cert-title">CERTIFICATE</div>
    <div class="cert-of">of</div>
    <div class="cert-type">{{ $result->result == 'pass' ? 'Achievement' : 'Participation' }}</div>
    <div class="presented">This is to proudly certify that</div>
    <div class="student-name">{{ $result->participant_name }}</div>
    <div class="school">{{ $result->participant_school }}</div>
    <div class="achieve-text">
      has successfully {{ $result->result == 'pass' ? 'completed and passed' : 'participated in' }} the quiz
      <strong>{{ strtoupper($result->quiz->certificate_title ?? $result->quiz->title) }}</strong>
      and demonstrated knowledge with a total score of
      <strong>{{ $result->score }} out of {{ $result->total_marks }}</strong>.
    </div>
    <div class="pills">
      <span class="pill pill-gold">&nbsp;Score: {{ $result->percentage }}%&nbsp;</span>
      &nbsp;&nbsp;
      <span class="pill pill-dark">&nbsp;Grade: {{ $result->grade }}&nbsp;</span>
      &nbsp;&nbsp;
      <span class="pill pill-dark">&nbsp;{{ $result->correct ?? $result->score }} Correct&nbsp;</span>
    </div>
  </div>

  <div class="bottom">
    <div class="bottom-left">
      <span class="strong">Certificate No:</span> {{ $result->certificate_number }}<br>
      <span class="strong">Issue Date:</span> {{ $result->created_at->format('d M Y') }}<br>
      <span class="strong">Email:</span> {{ $result->participant_email }}
    </div>
    <div class="bottom-center">
      <div class="sign-line"></div>
      <div class="sign-label">Authorized Signature</div>
      <div class="sign-sub">teachersofbihar.org</div>
    </div>
    <div class="bottom-right">
      <span class="strong">Phone:</span> {{ $result->participant_phone }}<br>
      <span class="strong">Website:</span> teachersofbihar.org<br>
      <span class="strong">&#10003; Verified</span>
    </div>
  </div>
</div>
</body>
</html>



