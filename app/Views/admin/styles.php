<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; background: #f4f4f4; }
    
    .navbar {
        background: #343a40;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }
    .navbar h2 { margin: 0; }
    .navbar > div { display: flex; gap: 0; }
    .navbar a {
        color: white;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 5px;
    }
    .navbar a:hover { background: #495057; }
    .navbar a.logout-btn { background: #dc3545; }
    .navbar a.logout-btn:hover { background: #c82333; }
    
    .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
    .cards { display: flex; gap: 20px; flex-wrap: wrap; }
    .card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        flex: 1;
        min-width: 200px;
        text-align: center;
        transition: transform 0.2s;
    }
    .card:hover { transform: translateY(-5px); }
    .card h3 { font-size: 24px; margin-bottom: 15px; }
    .card a {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 20px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }
    .card a:hover { background: #218838; }
    .welcome { margin-bottom: 30px; }
    
    /* Styles pour les pages d'admin génériques */
    .page-container { background: white; min-height: 100vh; }
    .content-container { max-width: 1200px; margin: 0 auto; padding: 30px 20px; }
    h1 { color: #333; margin-bottom: 20px; }
    .btn { display: inline-block; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-right: 10px; border: none; cursor: pointer; }
    .btn-add { background: #28a745; color: white; }
    .btn-add:hover { background: #218838; }
    .btn-edit { background: #007bff; color: white; }
    .btn-edit:hover { background: #0056b3; }
    .btn-delete { background: #dc3545; color: white; }
    .btn-delete:hover { background: #c82333; }
    .btn-back { background: #6c757d; color: white; }
    .btn-back:hover { background: #5a6268; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    th { background: #f8f9fa; font-weight: bold; }
    .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
    .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .difficulte { padding: 3px 8px; border-radius: 3px; font-size: 12px; }
    .facile { background: #d4edda; color: #155724; }
    .moyen { background: #fff3cd; color: #856404; }
    .difficile { background: #f8d7da; color: #721c24; }
</style>