<x-app-layout>
    <div style="margin-top: 10px" class="container">
        <form method="GET" action="{{ route('adds.search') }}" class="mx-auto">
            <div class="form-group">
                <div class="input-group mb-2">
                  <input type="text" class="form-control form-control-sm" name="search" placeholder="Search by name...">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                      More filters
                    </button>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary mx-2" type="submit">
                        Search
                    </button>
                  </div>
                </div>
              
                <div class="collapse mb-2" id="collapseFilters">
                  <div class="card card-body">
                    <div class="form-group mb-2">
                      <input type="number" class="form-control form-control-sm" name="min_price" placeholder="Minimum price...">
                    </div>
                    <div class="form-group mb-2">
                      <input type="number" class="form-control form-control-sm" name="max_price" placeholder="Maximum price...">
                    </div>
                    <div class="form-group mb-2">
                      <input type="text" class="form-control form-control-sm" name="keywords" placeholder="Keywords...">
                    </div>
                  </div>
                </div>
            </div>
        </form>
    </div>
    <div class="addsContainer grid grid-cols-3 gap-4">
      <div class="flex justify-center gap-5">
        <button class="btn btn-dark" onclick="sortByCreatedAt()">Most recent adds</button>
        <button class="btn btn-danger" onclick="sortByPopularity()">HOT</button>
      </div>
        @foreach($adds as $add)
            <div data-views="{{ $add->views }}" data-createdat="{{ $add->created_at }}" class="add border p-4">
                <h2 class="font-bold text-lg">{{ $add->title }}</h2>
                <p class="text-gray-600">{{ $add->description }}</p>
                <p class="font-bold">{{ $add->price }} €</p>
                @if ($add->picture)
                    @if (strpos($add->picture, '-') !== false)
                        <?php $pictures = explode('-', $add->picture); ?>
                        <div class="flex" style="flex-wrap: wrap;">
                            @foreach ($pictures as $picture)
                            <img style="max-height: 400px; max-width: 400px;" src="{{ asset('storage/images/' . $picture) }}" alt="{{ $add->title }}" class="mt-4">
                            @endforeach
                        </div>
                    @else
                    <img style="max-height: 400px; max-width: 400px;" src="{{ asset('storage/images/' . $add->picture) }}" alt="{{ $add->title }}" class="mt-4">
                    @endif
                @endif
                <a href="{{ route('newmessage', ['id' => $add->id]) }}" class="btn btn-outline-primary">Contact</a>
            </div>
         @endforeach
    </div>
</x-app-layout>
    
<script>
  
  function sortByCreatedAt() {
      const adds = document.querySelectorAll(".add");
      const addsArray = Array.from(adds);

      addsArray.sort(function(a, b) {
          const aTimestamp = new Date(a.dataset.createdat).getTime();
          const bTimestamp = new Date(b.dataset.createdat).getTime();

          return bTimestamp - aTimestamp;
      });

      const addsContainer = document.querySelector(".addsContainer");
      addsArray.forEach(function(add) {
          addsContainer.appendChild(add);
      });
  }

  function sortByPopularity() {
      const adds = document.querySelectorAll(".add");
      const addsArray = Array.from(adds);

      addsArray.sort(function(a, b) {
          const aViews = a.dataset.views;
          const bViews = b.dataset.views;

          return bViews - aViews;
      });

      const addsContainer = document.querySelector(".addsContainer");
      addsArray.forEach(function(add) {
          addsContainer.appendChild(add);
      });
  }

</script>