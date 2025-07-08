  @props(['user', 'size' => 'w-12 h-12'])
     @if ($user->image)
              <img class="{{ $size }} rounded-full " src="{{ $user->imageUrl() }}" alt="{{ $user->name }}">
          @else
          <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
                  class="{{ $size }}" alt="Dummy avatar">
              {{-- <img class="w-12 h-12 rounded-full" src="{{ asset('images/default-avatar.png') }}"
                  alt="{{ $user->name }}"> --}}
          @endif
