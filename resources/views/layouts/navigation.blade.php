<nav style="background: white; padding: 0 16px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: relative;">
    <div style="display: flex; align-items: center;">
        <a href="{{ route('dashboard') }}" style="font-weight: bold; font-size: 18px; text-decoration: none; color: #333;">
            {{ config('app.name') }}
        </a>
    </div>

    <div style="display: flex; align-items: center; position: relative;">
        <button id="dropdownBtn" style="display: flex; align-items: center; padding: 8px 12px; border: none; background: white; cursor: pointer; font-size: 14px; color: #555;">
            <span>{{ Auth::user()->name }}</span>
            <svg style="margin-left: 8px; width: 16px; height: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div id="dropdownMenu" style="display: none; position: absolute; right: 0; top: 40px; background: white; border: 1px solid #ddd; padding: 8px; border-radius: 4px; width: 150px;">
            <a href="{{ route('profile.edit') }}" style="display: block; padding: 8px; text-decoration: none; color: #333;">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="display: block; padding: 8px; background: none; border: none; color: #333; cursor: pointer; width: 100%; text-align: left;">Log Out</button>
            </form>
        </div>
    </div>
</nav>

<script>
    document.getElementById('dropdownBtn').addEventListener('click', function() {
        var menu = document.getElementById('dropdownMenu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function(event) {
        var isClickInside = document.getElementById('dropdownBtn').contains(event.target) || document.getElementById('dropdownMenu').contains(event.target);
        if (!isClickInside) {
            document.getElementById('dropdownMenu').style.display = 'none';
        }
    });
</script>
