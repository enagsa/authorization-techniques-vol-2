<li class="nav-item">
  <a class="nav-link" href="{{ asset('/admin/posts') }}">Posts</a>
</li>
<li>
	<a class="dropdown-item" href="{{ route('logout') }}"
       onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>