      <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400 justify-center">
          <li class="me-2">
              <a href="{{ route('dashboard') }}"
                  class="inline-block px-4 py-2 rounded-lg {{ !$selectedCategory ? 'text-white bg-blue-600' : 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                  All
              </a>
          </li>
          @forelse ($categories as $category)
              <li class="me-2">
                  <a href="{{ route('post.category', $category) }}"
                      class="inline-block px-4 py-2 rounded-lg {{ $selectedCategory == $category->id ? 'text-white bg-blue-600' : 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                      {{ $category->name }}
                  </a>
              </li>
          @empty

              {{ $slot }}
          @endforelse
      </ul>
