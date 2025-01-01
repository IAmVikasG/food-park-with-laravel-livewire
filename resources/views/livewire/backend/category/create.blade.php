<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1>{{ $isEditMode ? 'Edit' : 'Create' }} Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Category</a></div>
            <div class="breadcrumb-item">{{ $isEditMode ? 'Edit' : 'Create' }} Category</div>
        </div>
    </div>

    <div class="section-body">
        <livewire:success-message />

        <div class="card">
            <div class="card-header">
                <h4>Category Details</h4>
            </div>

            <form wire:submit.prevent="save">
                <div class="card-body">
                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input
                            wire:model.blur="name"
                            type="text"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter category name"
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug Field -->
                    <div class="form-group">
                        <label for="slug" class="required">Slug</label>
                        <input
                            wire:model.blur="slug"
                            type="text"
                            id="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            placeholder="category-slug"
                        >
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type Field -->
                    <div class="form-group">
                        <label for="type" class="required">Type</label>
                        <select
                            wire:model="type"
                            id="type"
                            class="form-control @error('type') is-invalid @enderror"
                        >
                            <option value="">Select Type</option>
                            @foreach($categoryTypes as $categoryType)
                                <option value="{{ $categoryType->value }}">
                                    {{ str_replace('_', ' ', ucfirst(strtolower($categoryType->name))) }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parent Category Field -->
                    <div class="form-group">
                        <label for="parentId">Parent Category</label>
                        <select
                            wire:model="parentId"
                            id="parentId"
                            class="form-control @error('parentId') is-invalid @enderror"
                        >
                            <option value="">None</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('parentId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            wire:model="description"
                            id="description"
                            rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter category description"
                        ></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div class="form-group">
                        <label for="order">Sort Order</label>
                        <input
                            wire:model="order"
                            type="number"
                            id="order"
                            class="form-control @error('order') is-invalid @enderror"
                            min="0"
                        >
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="form-group">
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="is_active" wire:model.lazy="is_active" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Active</span>
                        </label>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group">
                        <label for="image">Category Image</label>
                        <div class="custom-file">
                            <input
                                type="file"
                                wire:model="image"
                                class="custom-file-input @error('image') is-invalid @enderror"
                                id="image"
                                accept="image/*"
                            >
                            <label class="custom-file-label" for="image">
                                {{ $image ? $image->getClientOriginalName() : 'Choose file' }}
                            </label>
                        </div>

                        @if($isEditMode && $existingImage && !$image)
                            <div class="mt-3 position-relative">
                                <img src="{{ $existingImage->getUrl() }}" alt="Current Image" class="img-thumbnail" style="max-width: 200px">
                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm position-absolute"
                                    style="top: 5px; right: 5px"
                                    wire:click="deleteImage"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endif

                        @if($image)
                            <div class="mt-3">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="max-width: 200px">
                            </div>
                        @endif

                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SEO Information -->
                    <div class="form-group">
                        <h5>SEO Information</h5>
                        <hr>
                        <label for="metaTitle">Meta Title</label>
                        <input
                            wire:model="metaTitle"
                            type="text"
                            id="metaTitle"
                            class="form-control @error('metaTitle') is-invalid @enderror"
                            placeholder="Enter meta title"
                        >
                        @error('metaTitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="metaDescription">Meta Description</label>
                        <textarea
                            wire:model="metaDescription"
                            id="metaDescription"
                            class="form-control @error('metaDescription') is-invalid @enderror"
                            rows="3"
                            placeholder="Enter meta description"
                        ></textarea>
                        @error('metaDescription')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm mr-1"></span>
                        {{ $isEditMode ? 'Update' : 'Create' }} Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
