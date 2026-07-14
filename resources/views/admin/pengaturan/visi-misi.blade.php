<section class="tab-content active" id="tab-visimisi">

        <div class="settings-card">

            <div class="card-header">

                <h3>
                    <i class="fa-solid fa-bullseye"></i>
                    Visi & Misi
                </h3>

                <p>Kelola visi dan misi perusahaan</p>

            </div>

            <div class="card-body">

                <form id="visiMisiForm" action="{{ route('admin.visimisi.update') }}" method="POST">

                    @csrf

                    <div class="form-group">

                        <label>
                            Visi
                            <span class="required">*</span>
                        </label>

                        <textarea id="visiText" name="vision" class="form-control" rows="3" required>{{ old('vision', $vision->vision ?? '') }}</textarea>

                        <small class="form-help">
                            Tuliskan visi perusahaan secara jelas dan inspiratif.
                        </small>

                    </div>

                    <div class="form-group">

                        <label>
                            Misi
                            <span class="required">*</span>
                        </label>

                        <div id="misiContainer">

                            @forelse($missions as $mission)
                                <div class="misi-item">

                                    <textarea class="form-control misi-text" name="missions[]" rows="2" required>{{ old('missions.' . $loop->index, $mission->mission) }}</textarea>

                                    <button type="button" class="btn-remove-misi" onclick="removeMisi(this)">

                                        <i class="fa-solid fa-times"></i>

                                    </button>

                                </div>

                            @empty

                                <div class="misi-item">

                                    <textarea class="form-control misi-text" name="missions[]" rows="2" required></textarea>

                                    <button type="button" class="btn-remove-misi" onclick="removeMisi(this)">

                                        <i class="fa-solid fa-times"></i>

                                    </button>

                                </div>
                            @endforelse

                        </div>

                        <button type="button" class="btn-add-misi" onclick="addMisi()">

                            <i class="fa-solid fa-plus"></i>
                            Tambah Misi

                        </button>

                        <small class="form-help">
                            Setiap misi ditulis dalam satu baris.
                        </small>

                    </div>

                    <div class="form-actions">

                        <button type="submit" class="btn-simpan">

                            <i class="fa-solid fa-save"></i>
                            Simpan Visi & Misi

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>