  @props(['user', 'size' => 'w-12 h-12'])
     @if ($user->image)
              <img class="{{ $size }} rounded-full " src="{{ $user->imageUrl() }}" alt="{{ $user->name }}">
          @else
          <img src="{{ asset('images/default-avatar.png') }}"
                  class="{{ $size }}" alt="Dummy avatar">
              {{-- <img class="w-12 h-12 rounded-full" src="{{ asset('images/default-avatar.png') }}"
                  alt="{{ $user->name }}"> --}}
          @endif
