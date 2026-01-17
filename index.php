<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UAS Keamanan Data dan Informasi</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  :root{
    /* EDGY / NEON THEME */
    --bg-1:#070a11;
    --bg-2:#0b1020;

    --text: rgba(255,255,255,.92);
    --muted: rgba(255,255,255,.70);

    --card: rgba(255,255,255,.06);
    --card-border: rgba(255,255,255,.12);

    --cyan:#22d3ee;
    --purple:#a78bfa;
    --pink:#fb7185;
    --green:#34d399;
    --amber:#fbbf24;

    --warn-bg: rgba(251,191,36,.10);
    --warn-border: rgba(251,191,36,.25);
    --warn-text: rgba(255,236,190,.92);

    --shadow: 0 18px 60px rgba(0,0,0,.55);
    --shadow-soft: 0 12px 35px rgba(0,0,0,.40);

    --glow-cyan: 0 0 0 1px rgba(34,211,238,.25), 0 0 35px rgba(34,211,238,.18);
    --glow-pink: 0 0 0 1px rgba(251,113,133,.25), 0 0 35px rgba(251,113,133,.16);
    --glow-green: 0 0 0 1px rgba(52,211,153,.22), 0 0 35px rgba(52,211,153,.14);
  }

  body{
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
    padding: 20px;
    color: var(--text);
    background:
      radial-gradient(900px 520px at 15% 15%, rgba(34,211,238,.18), transparent 60%),
      radial-gradient(900px 520px at 85% 20%, rgba(167,139,250,.16), transparent 60%),
      radial-gradient(900px 520px at 55% 90%, rgba(251,113,133,.10), transparent 65%),
      linear-gradient(135deg, var(--bg-1), var(--bg-2));
    overflow-x: hidden;
  }

  /* grain */
  body::before{
    content:"";
    position: fixed;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='120' height='120' filter='url(%23n)' opacity='.12'/%3E%3C/svg%3E");
    opacity: .08;
    pointer-events:none;
    z-index:-1;
  }

  .container{ max-width: 1200px; margin: 0 auto; }

  .header{
    background: linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.05));
    border: 1px solid var(--card-border);
    padding: 30px;
    border-radius: 16px;
    box-shadow: var(--shadow);
    margin-bottom: 22px;
    text-align: center;
    backdrop-filter: blur(10px);
  }

  .header h1{
    margin-bottom: 10px;
    letter-spacing: .2px;
    background: linear-gradient(90deg, #fff, rgba(34,211,238,.95), rgba(167,139,250,.95));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .header p{
    color: var(--muted);
    font-size: 14px;
    line-height: 1.7;
  }
  .header p strong{ color: rgba(255,255,255,.92); }

  .info-box{
    background: var(--warn-bg);
    border: 1px solid var(--warn-border);
    border-left: 6px solid rgba(251,191,36,.65);
    padding: 15px;
    border-radius: 14px;
    margin: 18px 0;
    box-shadow: var(--shadow-soft);
    color: var(--warn-text);
  }
  .info-box strong{ color: var(--warn-text); }

  .modules-grid{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 22px;
    margin-top: 20px;
  }

  .module-card{
    background: var(--card);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 28px;
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(10px);
    transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
  }
  .module-card:hover{
    transform: translateY(-4px);
    border-color: rgba(255,255,255,.18);
    box-shadow: var(--shadow);
  }

  .module-card h2{
    color: rgba(255,255,255,.95);
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 3px solid rgba(34,211,238,.55);
  }
  .vulnerable-card h2{ border-bottom-color: rgba(251,113,133,.65); }
  .secure-card h2{ border-bottom-color: rgba(52,211,153,.65); }

  /* OVERRIDE inline text gray (#666) inside module card */
  .module-card p{ color: var(--muted) !important; }

  .module-list{ list-style: none; }

  .module-list li{
    margin: 14px 0;
    padding: 14px;
    background: rgba(255,255,255,.045);
    border: 1px solid rgba(255,255,255,.10);
    border-radius: 14px;
    transition: transform .22s ease, box-shadow .22s ease, background .22s ease, border-color .22s ease;
  }

  /* per-card hover glow (biar dalemnya beda feel) */
  .vulnerable-card .module-list li:hover{
    background: rgba(255,255,255,.06);
    transform: translateX(4px);
    border-color: rgba(251,113,133,.30);
    box-shadow: var(--glow-pink);
  }
  .secure-card .module-list li:hover{
    background: rgba(255,255,255,.06);
    transform: translateX(4px);
    border-color: rgba(52,211,153,.28);
    box-shadow: var(--glow-green);
  }

  .module-list a{
    text-decoration: none;
    color: var(--text);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    font-weight: 650;
  }

  /* ini yang "dalem" banget: span pertama (isi) + panah kanan */
  .module-list a > span:first-child{
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    color: var(--text);
  }

  /* icon jadi bubble neon */
  .module-list .icon{
    display: inline-flex;
    width: 38px;
    height: 38px;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: linear-gradient(135deg, rgba(34,211,238,.18), rgba(167,139,250,.14));
    border: 1px solid rgba(255,255,255,.14);
    box-shadow: 0 10px 25px rgba(0,0,0,.25);
    font-size: 18px;
  }

  /* panah kanan jadi tombol */
  .module-list a > span:last-child{
    display: inline-flex;
    width: 42px;
    height: 42px;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,.14);
    background: rgba(255,255,255,.05);
    color: rgba(34,211,238,.95);
    transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    flex: 0 0 auto;
  }
  .vulnerable-card .module-list a > span:last-child{ color: rgba(251,113,133,.95); }
  .secure-card .module-list a > span:last-child{ color: rgba(52,211,153,.95); }

  .module-list li:hover a > span:last-child{
    transform: translateX(3px);
    background: rgba(255,255,255,.07);
  }
  .vulnerable-card .module-list li:hover a > span:last-child{ box-shadow: var(--glow-pink); }
  .secure-card .module-list li:hover a > span:last-child{ box-shadow: var(--glow-green); }

  .badge{
    display: inline-block;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    margin-left: 8px;
    border: 1px solid rgba(255,255,255,.14);
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.90);
  }

  .badge-danger{
    border-color: rgba(251,113,133,.35);
    background: rgba(251,113,133,.12);
    box-shadow: var(--glow-pink);
  }

  .badge-success{
    border-color: rgba(52,211,153,.30);
    background: rgba(52,211,153,.10);
    box-shadow: var(--glow-green);
  }

  .footer{
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.12);
    padding: 18px;
    border-radius: 16px;
    text-align: center;
    margin-top: 24px;
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(10px);
  }

  .footer p{
    color: var(--muted);
    font-size: 14px;
    line-height: 1.7;
  }
  .footer p strong{ color: rgba(255,255,255,.92); }

  /* override inline footer link color (#667eea) */
  .footer a{
    color: rgba(34,211,238,.95) !important;
    text-decoration: none;
    font-weight: 700;
  }
  .footer a:hover{
    text-decoration: underline;
    filter: brightness(1.1);
  }

  @media (max-width: 540px){
    .modules-grid{ grid-template-columns: 1fr; }
  }
</style>


</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔒 UAS Keamanan Data dan Informasi</h1>
            <p><strong>Nama:</strong> Famella Mefti <strong>NIM:</strong> C2C0231</p>
            <p><strong>Mata Kuliah:</strong> IF2350073 - MK07 (Keamanan Data dan Informasi Praktikum)</p>
            <p><strong>Dosen:</strong> Dr. Dhendra Marutho, S.Kom., M.Kom</p>
        </div>

        <div class="info-box">
            <strong>⚠️ PERHATIAN:</strong> Aplikasi ini dibuat untuk tujuan edukasi dan pengujian keamanan. 
            Hanya jalankan di localhost. JANGAN deploy ke internet!
        </div>

        <div class="modules-grid">
            <!-- Vulnerable Version -->
            <div class="module-card vulnerable-card">
                <h2>🔓 Versi VULNERABLE</h2>
                <p style="color: #666; margin-bottom: 20px;">Modul dengan kerentanan keamanan untuk demonstrasi</p>
                
                <ul class="module-list">
                    <li>
                        <a href="vulnerable/login.php">
                            <span>
                                <span class="icon">🔑</span>
                                Login Module
                                <span class="badge badge-danger">Brute Force</span>
                            </span>
                            <span>→</span>
                        </a>
                    </li>
                    <li>
                        <a href="vulnerable/comment.php">
                            <span>
                                <span class="icon">💬</span>
                                Comment Module
                                <span class="badge badge-danger">XSS</span>
                            </span>
                            <span>→</span>
                        </a>
                    </li>
                    <li>
                        <a href="vulnerable/fileviewer.php">
                            <span>
                                <span class="icon">📁</span>
                                File Viewer Module
                                <span class="badge badge-danger">LFI</span>
                            </span>
                            <span>→</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Secure Version -->
            <div class="module-card secure-card">
                <h2>🔐 Versi SECURE</h2>
                <p style="color: #666; margin-bottom: 20px;">Modul dengan implementasi keamanan yang baik</p>
                
                <ul class="module-list">
                    <li>
                        <a href="secure/login.php">
                            <span>
                                <span class="icon">🔑</span>
                                Login Module
                                <span class="badge badge-success">Protected</span>
                            </span>
                            <span>→</span>
                        </a>
                    </li>
                    <li>
                        <a href="secure/comment.php">
                            <span>
                                <span class="icon">💬</span>
                                Comment Module
                                <span class="badge badge-success">Protected</span>
                            </span>
                            <span>→</span>
                        </a>
                    </li>
                    <li>
                        <a href="secure/fileviewer.php">
                            <span>
                                <span class="icon">📁</span>
                                File Viewer Module
                                <span class="badge badge-success">Protected</span>
                            </span>
                            <span>→</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <p>📝 <strong>Catatan:</strong> Pastikan Apache sudah berjalan di XAMPP</p>
            <p>🔗 Repository: <a href="#" style="color: #667eea;">GitHub Link</a></p>
        </div>
    </div>
</body>
</html>