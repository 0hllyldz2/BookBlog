@extends('front.layouts.master')
@section('title', 'İletişim')
@section('bg', '/front/assets/img/contact-bg.jpg')
@section('content')

    <div class="col-md-10 col-lg-8 col-xl-7 mx-auto centered-form">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <p class="text-center">Bizimle iletişime geçebilirsiniz!</p>
        <div class="my-5">
            <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="POST" action="{{ route('contact.post') }}">
                @csrf
                <div class="form-floating">
                    <input class="form-control" value="{{ old('name') }}" id="name" type="text" name="name"
                        placeholder="Adınızı ve Soyadınızı girin..." required />
                    <label for="name">Ad Soyad</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" value="{{ old('email') }}" id="email" type="email" name="email"
                        placeholder="E-posta adresinizi girin..." required />
                    <label for="email">E-mail Adresi</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" value="{{ old('topic') }}" id="topic" type="text" name="topic"
                        placeholder="Konu girin..." required />
                    <label for="topic">Konu</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" id="message" name="message" placeholder="Mesajınızı girin..." style="height: 12rem"
                        required>{{ old('message') }}</textarea>
                    <label for="message">Mesajınız</label>
                </div>
                <br />
                <button class="btn btn-primary text-uppercase" id="sendMessageButton" type="submit">Gönder</button>
            </form>
        </div>
    </div>

@endsection
