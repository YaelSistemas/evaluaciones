@extends('layouts.admin')
@section('title', 'Usuarios')
@section('content')
<style>
  :root{
    --bg:#f4f6f8; --card:#ffffff; --text:#222; --muted:#6b7280;
    --primary:#1f4cd6; --primary-hover:#183db0; --danger:#c53030;
    --border:#e5e7eb; --ring:#9db3ff;
  }
  .page-wrap{max-width:1000px;margin:40px auto;padding:0 16px}
  .card{background:var(--card);border:1px solid var(--border);border-radius:12px;box-shadow:0 6px 18px rgba(0,0,0,.06);overflow:hidden}
  .card-hd{padding:18px 22px;border-bottom:1px solid var(--border);background:#fafafa;display:flex;justify-content:space-between;align-items:center}
  .card-title{margin:0;font-size:22px;color:var(--text);font-weight:700}
  .btn{display:inline-flex;align-items:center;justify-content:center;padding:8px 14px;border-radius:6px;border:1px solid transparent;font-weight:600;cursor:pointer;transition:.15s;text-decoration:none}
  .btn-primary{background:var(--primary);color:#fff}.btn-primary:hover{background:var(--primary-hover)}
  .btn-secondary{background:#fff;color:#374151;border-color:var(--border)}.btn-secondary:hover{background:#f3f4f6}
  .btn-danger{background:var(--danger);color:#fff}.btn-danger:hover{background:#a11d1d}
  .btn-icon{width:38px;height:38px;padding:0;border-radius:8px}
  .btn-icon i{font-size:14px}

  .table{width:100%;border-collapse:collapse}
  .table th,.table td{padding:12px 14px;text-align:left;border-bottom:1px solid var(--border)}
  .table th{background:#f9fafb;font-size:14px;color:#555}
  .table td{font-size:14px;color:#333}
  .badge{display:inline-block;padding:3px 8px;font-size:12px;border-radius:12px;font-weight:600}
  .badge-active{background:#d1fae5;color:#065f46}
  .badge-inactive{background:#fee2e2;color:#991b1b}
  .badge-admin{background:#e0e7ff;color:#3730a3}
  .actions{display:flex;gap:6px}
  .searchbar{margin-bottom:16px;display:flex;gap:10px}
  .searchbar input{flex:1;padding:8px 12px;border:1px solid var(--border);border-radius:8px}

  /* Toggle switch */
  .switch {position:relative;display:inline-block;width:46px;height:24px}
  .switch input {opacity:0;width:0;height:0}
  .slider {position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:#ccc;transition:.3s;border-radius:34px}
  .slider:before {position:absolute;content:"";height:18px;width:18px;left:3px;bottom:3px;background:white;transition:.3s;border-radius:50%}
  .switch input:checked + .slider {background:var(--primary)}
  .switch input:checked + .slider:before {transform:translateX(22px)}
</style>

<div class="page-wrap">
  <div class="card">
    <div class="card-hd">
      <h1 class="card-title">Usuarios</h1>
      <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Nuevo usuario</a>
    </div>

    <div class="card-bd" style="padding:20px">
      {{-- Barra de búsqueda --}}
      <form method="get" class="searchbar">
        <input type="text" name="search" value="{{ $q ?? '' }}" placeholder="Buscar por nombre o email...">
        <button type="submit" class="btn btn-secondary">Buscar</button>
      </form>

      {{-- Tabla --}}
      <table class="table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Rol</th>
            <th>Activo</th> {{-- nueva columna con toggle --}}
            <th style="width:140px">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
            <tr>
              <td>{{ $u->name }}</td>
              <td>{{ $u->email }}</td>
              <td>
                @if($u->is_active)
                  <span class="badge badge-active">Activo</span>
                @else
                  <span class="badge badge-inactive">Inactivo</span>
                @endif
              </td>
              <td>
                @if($u->is_admin)
                  <span class="badge badge-admin">Administrador</span>
                @else
                  Usuario
                @endif
              </td>

              {{-- TOGGLE Activo/Inactivo (fuera de Acciones) --}}
              <td>
                <form method="post" action="{{ route('admin.users.toggle',$u) }}">
                  @csrf
                  @method('PATCH')
                  <label class="switch" title="Activar/Inactivar">
                    <input type="checkbox" {{ $u->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                    <span class="slider"></span>
                  </label>
                </form>
              </td>

              {{-- Acciones con íconos --}}
              <td>
                <div class="actions">
                  <a href="{{ route('admin.users.edit',$u) }}" class="btn btn-secondary btn-icon" title="Editar">
                    <i class="fa-solid fa-pen"></i>
                  </a>

                  <form method="post" action="{{ route('admin.users.destroy',$u) }}"
                        onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-icon" title="Eliminar">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center; padding:20px; color:var(--muted)">No se encontraron usuarios.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{-- Paginación --}}
      <div style="margin-top:20px">
        {{ $users->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
