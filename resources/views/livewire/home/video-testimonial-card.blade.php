@props(['testimonial', 'embedUrl', 'thumbnailUrl'])

<div class="group cursor-pointer" onclick="openVideoModal('{{ $embedUrl }}')">
    <div class="relative overflow-hidden rounded-xl shadow-lg">
        <img src="{{ $thumbnailUrl }}" alt="{{ $testimonial->student_name }}" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
            <div class="w-20 h-20 bg-white bg-opacity-90 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-125">
                <i class="fas fa-play text-purple-600 text-2xl ml-1"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
            <h4 class="text-white font-bold text-lg">{{ $testimonial->student_name }}</h4>
            <p class="text-white text-sm">{{ $testimonial->course }}, {{ $testimonial->university }}</p>
        </div>
    </div>
    <div class="mt-4">
        <div class="flex text-yellow-400 mb-2">
            @for($i = 0; $i < $testimonial->rating; $i++)
                <i class="fas fa-star"></i>
            @endfor
        </div>
        @if($testimonial->quote)
            <p class="text-gray-600 text-sm">"{{ $testimonial->quote }}"</p>
        @endif
    </div>
</div>
