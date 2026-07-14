<section class="tab-content" id="tab-profile">

        <div class="settings-card">

            <div class="card-header">

                <h3>
                    <i class="fa-solid fa-building"></i>
                    Profile Perusahaan
                </h3>

                <p>
                    Kelola informasi utama perusahaan
                </p>

            </div>

            <div class="card-body">

                <form action="{{ route('admin.profile.update') }}" method="POST"
                enctype="multipart/form-data">
                    
                    @csrf

                    <div class="form-group">

                        <label>
                            Nama Website
                            <span class="required">*</span>
                        </label>

                        <input type="text" id="websiteName" name="website_name" class="form-control"
                            placeholder="Masukkan nama website"
                            value="{{ old('website_name', $setting->website_name ?? '') }}">

                    </div>

                    <div class="form-group">

                        <label>

                            Logo Saat Ini

                        </label>

                        <div class="logo-current">

                            <img src="{{ Storage::url($setting->website_logo) }}" alt="Logo Rumah Moeda">

                        </div>

                    </div>

                    <div class="form-group">

                        <label>

                            Upload Logo Baru

                            <span class="required">*</span>

                        </label>

                        <div class="logo-upload">

                            <input type="file" id="formLogo" name="website_logo" accept=".png,.jpg,.jpeg,.svg"
                                onchange="previewLogo(event)">

                            <div class="logo-preview" id="logoPreview">

                                <i class="fa-solid fa-cloud-upload-alt"></i>

                                <p>

                                    Klik untuk upload logo

                                </p>

                                <small>

                                    Format :
                                    JPG, PNG, SVG

                                    <br>

                                    Maksimal 2 MB

                                    <br>

                                    Rekomendasi ukuran
                                    200 × 80 px

                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <label>
                            Deskripsi Website
                            <span class="required">*</span>
                        </label>

                        <textarea id="websiteDescription" name="website_description" class="form-control" rows="5"
                            placeholder="Masukkan deskripsi website">{{ old('website_description', $setting->website_description ?? '') }}</textarea>

                    </div>

                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>
                                Nomor Telepon
                            </label>

                            <input type="text" id="phoneNumber" name="phone_number" class="form-control"
                                placeholder="+62 812-xxxx-xxxx"
                                value="{{ old('phone_number', $setting->phone_number ?? '') }}">

                        </div>

                        <div class="form-group form-group-half">

                            <label>
                                Email
                            </label>

                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="info@rumahmoeda.id" value="{{ old('email', $setting->email ?? '') }}">

                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>
                                Nomor Fax
                            </label>

                            <input type="text" id="faxNumber" name="fax_number" class="form-control"
                                placeholder="Nomor Fax" value="{{ old('fax_number', $setting->fax_number ?? '') }}">

                        </div>

                    </div>

                    <div class="form-group">

                        <label>
                            Alamat
                        </label>

                        <textarea id="address" name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address', $setting->address ?? '') }}</textarea>

                    </div>

                    <hr>

                    <h4 class="section-title">

                        Sosial Media

                    </h4>

                    <div class="form-group">

                        <label>

                            Instagram

                        </label>

                        <input type="text" id="instagram" name="instagram_url" class="form-control"
                            placeholder="https://instagram.com/..."
                            value="{{ old('instagram_url', $setting->instagram_url ?? '') }}">

                    </div>

                    <div class="form-group">

                        <label>

                            Facebook

                        </label>

                        <input type="text" id="facebook" name="facebook_url" class="form-control"
                            placeholder="https://facebook.com/..."
                            value="{{ old('facebook_url', $setting->facebook_url ?? '') }}">

                    </div>

                    <div class="form-group">

                        <label>

                            TikTok

                        </label>

                        <input type="text" id="tiktok" name="tiktok_url" class="form-control"
                            placeholder="https://tiktok.com/..."
                            value="{{ old('tiktok_url', $setting->tiktok_url ?? '') }}">

                    </div>

                    <div class="form-actions">

                        <button type="submit" class="btn-simpan">

                            <i class="fa-solid fa-save"></i>

                            Simpan Profile

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>