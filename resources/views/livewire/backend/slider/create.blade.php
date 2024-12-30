<section class="section">
  <div class="section-header">
    <h1>Slider {{ $isEditMode ? 'Edit' : 'Create' }} Form</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Slider</a></div>
      <div class="breadcrumb-item">{{ $isEditMode ? 'Edit' : 'Create' }} Slider</div>
    </div>
  </div>

  <div class="section-body">
    <livewire:success-message />

    <div class="row">
      <div class="col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ $isEditMode ? 'Edit' : 'Create' }} Slider</h4>
          </div>

          <form wire:submit="save">
            <div class="card-body">
              <!-- Offer Field -->
              <div class="form-group">
                <label for="offer">Offer</label>
                <input wire:model.lazy="offer" type="text" id="offer"
                  class="form-control @error('offer') is-invalid @enderror">
                @error('offer')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <!-- Title Field -->
              <div class="form-group">
                <label for="title">Title</label>
                <input wire:model.lazy="title" type="text" id="title"
                  class="form-control @error('title') is-invalid @enderror">
                @error('title')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <!-- Subtitle Field -->
              <div class="form-group">
                <label for="subtitle">Subtitle</label>
                <input wire:model.lazy="subtitle" type="text" id="subtitle"
                  class="form-control @error('subtitle') is-invalid @enderror">
                @error('subtitle')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <!-- Description Field -->
              <div class="form-group">
                <label for="description">Description</label>
                <textarea wire:model.lazy="description" id="description"
                  class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <!-- Button Link -->
              <div class="form-group">
                <label for="btn_link">Button Link</label>
                <input wire:model.lazy="btn_link" type="url" id="btn_link"
                  class="form-control @error('btn_link') is-invalid @enderror">
                @error('btn_link')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <!-- Order Field -->
              <div class="form-group">
                <label for="order">Order</label>
                <input wire:model.lazy="order" type="number" id="order"
                  class="form-control @error('order') is-invalid @enderror">
                @error('order')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <!-- Active Field -->
              <div class="form-group">
                <label class="custom-switch mt-2">
                  <input type="checkbox" name="is_active" wire:model.lazy="is_active" @if($is_active) checked @endif class="custom-switch-input">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>
                </label>
                @error('is_active')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

                <!-- Image Upload -->
                <div class="form-group">
                    <label for="image">Slider Image</label>

                    @if($isEditMode && $existingImage && !$image)
                        <div class="mb-3">
                            <img src="{{ $existingImage->getUrl() }}" alt="Current Image" class="img-thumbnail" width="200">
                            <button type="button" class="btn btn-danger btn-sm ml-2" wire:click="deleteImage">
                                Delete Image
                            </button>
                        </div>
                    @endif

                    <input wire:model.lazy="image" type="file" id="image"
                        class="form-control @error('image') is-invalid @enderror">

                    @if (!$isEditMode && $image)
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="img-thumbnail mt-2" width="200">
                    @endif

                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

              <!-- Submit Button -->
              <button type="submit" wire:loading.attr="disabled" class="btn btn-primary">
                    {{ $isEditMode ? 'Update' : 'Create' }} Slider
                </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
