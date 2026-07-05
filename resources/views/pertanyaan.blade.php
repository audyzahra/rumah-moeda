@extends('Layouts.app')

@section('title','Pertanyaan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pertanyaan.css') }}">
@endpush

@section('content')

<section class="faq-header">

    <div class="header-text">

        <h1>
            Pertanyaan Umum
        </h1>

        <p>
            Temukan jawaban dari pertanyaan yang sering diajukan.
        </p>

    </div>

</section>

<section class="faq-container">

    @foreach($faqs as $faq)

        <div class="faq-item">

            <button class="faq-question">

                {{ $faq->question }}

                <i class="fa-solid fa-chevron-down"></i>

            </button>

            <div class="faq-answer">

                {!! nl2br(e($faq->answer)) !!}

            </div>

        </div>

    @endforeach

</section>

@endsection


@push('scripts')

<script>

document.querySelectorAll(".faq-question").forEach(button=>{

    button.addEventListener("click",()=>{

        const item = button.parentElement;

        document.querySelectorAll(".faq-item").forEach(faq=>{

            if(faq!==item){

                faq.classList.remove("active");

            }

        });

        item.classList.toggle("active");

    });

});

</script>

@endpush
