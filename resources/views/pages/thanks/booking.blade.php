@extends('layouts.app')

@section('head') <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-16653306107"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'AW-16653306107');
</script>
<style>
    .thank-you-container,
    .thank-you-header,
    .thank-you-line,
    .thank-you-content {
        color: black;
    }
</style>
@endsection

@section('title')
Order Confirmation
@endsection

@section('main_content')
<div class="thank-you-container">
    <h1 class="thank-you-header">Thank you for your order!</h1>
    <div class="thank-you-line"></div>
    <div class="thank-you-content">
        <p>We appreciate your order and reaching out to us. One of our team members
            will review your information and get back to you shortly to confirm the details and discuss any further
            requirements. We aim to respond as quickly as possible.</p>
    </div>
</div>
@endsection
