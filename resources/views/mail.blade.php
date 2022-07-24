<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
</head>
<body>
{{-- <p>hello Band admin {{ $data->sender }}</p>
<p>this is your title {{ $data->title }}.</p>
<p>message {{ $data->body }}.</p> --}}

<p>hello Band admin {{ $data['sender'] }}</p>
<p>this is your title {{ $data['title'] }}.</p>
<p>message {{ $data['body'] }}.</p>
<p>this is a test message</p>
<a href="{{url('/')}}">{{url('/')}}</a>


</body>
</html>