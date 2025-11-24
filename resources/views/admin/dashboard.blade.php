<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gëstu Ndox Mi</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        
        .admin-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .admin-navbar {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 2rem;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
            text-decoration: none;
        }

        .brand-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(14, 165, 233, 0.4);
            animation: pulse 2s infinite;
        }

        .brand-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .brand-text h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 0.85rem;
            opacity: 0.8;
            margin: 0;
        }

        .admin-actions {
            display: flex;
            align-items: center;
            gap: 2rem;
            justify-self: end;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(14, 165, 233, 0.3);
            border-top: 4px solid #0ea5e9;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

       
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .success-alert {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #065f46;
            border: 2px solid #10b981;
            border-left: 6px solid #10b981;
            padding: 1.2rem 1.8rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.2);
            animation: slideInDown 0.5s ease;
        }

        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--card-color);
            box-shadow: 0 0 20px var(--card-color);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .stat-card:hover::after {
            opacity: 1;
            animation: shimmer 1.5s ease-in-out;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 16px 50px rgba(0, 0, 0, 0.15);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .stat-title {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--card-color), var(--card-color-light));
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon i {
            font-size: 1.8rem;
            color: white;
        }

        .stat-value {
            font-size: 3rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #0f172a, #374151);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-trend {
            font-size: 0.9rem;
            color: #10b981;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

       
        .charts-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .chart-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

       
        .map-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .map-header {
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-bottom: 1px solid #e2e8f0;
        }

        .map-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .map-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0.5rem 0 0 0;
        }

        #map {
            height: 500px;
            width: 100%;
        }

        
        .table-section {
            width: 100%;
            overflow-x: auto;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .table-header {
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-title-section {
            flex: 1;
        }

        .table-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .table-subtitle {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0;
        }

        .table-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.9rem;
            background: white;
            transition: all 0.3s ease;
            min-width: 250px;
        }

        .search-input:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .filter-select {
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.9rem;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 150px;
        }

        .filter-select:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .table-container {
            width: 100%;
            min-width: 1000px; 
            overflow-x: auto;
            padding: 1rem;
        }

        .reports-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 1rem;
        }

        .reports-table th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }

        .reports-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Définir des largeurs fixes pour chaque colonne */
        .reports-table th:nth-child(1), 
        .reports-table td:nth-child(1) { width: 15%; } /* Nom */

        .reports-table th:nth-child(2), 
        .reports-table td:nth-child(2) { width: 20%; } /* Contact */

        .reports-table th:nth-child(3), 
        .reports-table td:nth-child(3) { width: 15%; } /* Problème */

        .reports-table th:nth-child(4), 
        .reports-table td:nth-child(4) { width: 25%; } /* Adresse */

        .reports-table th:nth-child(5), 
        .reports-table td:nth-child(5) { width: 15%; } /* Statut */

        .reports-table th:nth-child(6), 
        .reports-table td:nth-child(6) { width: 10%; } /* Actions */

        .report-row {
        cursor: pointer;
        transition: background-color 0.2s ease;
}

    .report-row:hover {
    background-color: rgba(14, 165, 233, 0.05);
}

        /* Gestion du contenu long */
        .truncate {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-badge {
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .status-en-attente {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 1px solid #f59e0b;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .status-en-cours {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border: 1px solid #3b82f6;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .status-resolu {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
            border: 1px solid #16a34a;
            box-shadow: 0 4px 15px rgba(22, 163, 74, 0.3);
        }

        .problem-type {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.2rem;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 12px;
            font-weight: 600;
            border: 1px solid #cbd5e1;
            transition: all 0.3s ease;
        }

        .problem-type:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .action-controls {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .status-select {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .status-select:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
            transform: scale(1.02);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .btn-delete::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: all 0.5s ease;
        }

        .btn-delete:hover::before {
            left: 100%;
        }

        .btn-delete:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.4);
        }

        .address-cell {
            position: relative;
            font-size: 0.9rem;
            color: #64748b;
            max-width: 200px;
        }
        
        .address-cell div.truncated-address {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 100%;
            font-weight: 500;
        }

        .address-full {
            position: absolute;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            z-index: 1000;
            max-width: 350px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
            padding: 1rem;
        }

        .pagination-btn {
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            background: white;
            color: #64748b;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .pagination-btn:hover,
        .pagination-btn.active {
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.3);
        }

        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        
        .report-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(15px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .report-modal {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 0;
            animation: modalFadeIn 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .report-modal-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 2rem;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .report-modal-title {
            font-size: 1.4rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .report-modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .report-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .report-modal-body {
            padding: 2rem;
        }

        .report-detail-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f1f5f9;
            border-radius: 16px;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            padding: 1.5rem;
        }

        .report-detail-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 1.5rem;
        }

        .report-detail-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .report-detail-content {
            color: #64748b;
            line-height: 1.8;
            font-weight: 500;
        }

        .report-detail-meta {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .report-meta-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: #64748b;
            background: white;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

       
        .sort-icon {
            margin-left: 0.5rem;
            opacity: 0.5;
            transition: all 0.3s ease;
        }
        
        th:hover .sort-icon {
            opacity: 1;
        }

       
        .marker-cluster-small {
            background-color: rgba(14, 165, 233, 0.6);
        }
        .marker-cluster-small div {
            background-color: rgba(14, 165, 233, 0.9);
        }
        .marker-cluster-medium {
            background-color: rgba(245, 158, 11, 0.6);
        }
        .marker-cluster-medium div {
            background-color: rgba(245, 158, 11, 0.9);
        }
        .marker-cluster-large {
            background-color: rgba(239, 68, 68, 0.6);
        }
        .marker-cluster-large div {
            background-color: rgba(239, 68, 68, 0.9);
        }
        .marker-cluster {
            background-clip: padding-box;
            border-radius: 20px;
        }
        .marker-cluster div {
            width: 30px;
            height: 30px;
            margin-left: 5px;
            margin-top: 5px;
            text-align: center;
            border-radius: 15px;
            font: 12px "Helvetica Neue", Arial, Helvetica, sans-serif;
        }
        .marker-cluster span {
            line-height: 30px;
            color: white;
            font-weight: bold;
        }

        /* ANIMATIONS */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes modalFadeIn {
            0% { opacity: 0; transform: scale(0.95) translateY(-20px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .charts-section {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 992px) {
            .admin-container {
                padding: 1.5rem;
            }
            
            .table-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input {
                min-width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .admin-container {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .admin-navbar {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .table-controls {
                width: 100%;
            }
            
            .search-input,
            .filter-select {
                width: 100%;
            }
        }

        /* modal de suppression */
.delete-modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(8px);
    z-index: 3000;
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.3s ease;
}

.delete-modal {
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    padding: 0;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transform: scale(0.95);
    opacity: 0;
    animation: scaleIn 0.3s ease forwards;
}

.delete-modal-header {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    padding: 1.5rem;
    border-radius: 20px 20px 0 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.delete-modal-header i {
    font-size: 1.5rem;
}

.delete-modal-title {
    font-size: 1.25rem;
    font-weight: 600;
}

.delete-modal-body {
    padding: 2rem;
    color: #374151;
    font-size: 1rem;
    line-height: 1.6;
}

.delete-modal-warning {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: #fef2f2;
    border: 1px solid #fee2e2;
    border-radius: 12px;
    margin: 1rem 0;
}

.delete-modal-warning i {
    color: #ef4444;
    font-size: 1.25rem;
}

.delete-modal-actions {
    padding: 1.5rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    border-top: 1px solid #e5e7eb;
}

.btn-cancel {
    padding: 0.75rem 1.5rem;
    border: 1px solid #e5e7eb;
    background: white;
    color: #374151;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    background: #f3f4f6;
    transform: translateY(-1px);
}

.btn-confirm-delete {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-confirm-delete:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.5);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes scaleIn {
    from { 
        transform: scale(0.95);
        opacity: 0;
    }
    to { 
        transform: scale(1);
        opacity: 1;
    }
}



.premium-badge {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 8px 32px rgba(245, 158, 11, 0.25);
}

.btn-premium {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 8px 32px rgba(245, 158, 11, 0.25);
}

.premium-modal-overlay {
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(10px);
}

.premium-modal {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-radius: 24px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    overflow: hidden;
    max-width: 800px;
}

.premium-modal-header {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    padding: 2rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.premium-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    padding: 3rem;
}

.premium-feature {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(245, 158, 11, 0.2);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
}

.premium-feature:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.1);
}

.premium-feature i {
    font-size: 2.5rem;
    color: #f59e0b;
    margin-bottom: 1.5rem;
}

.premium-feature h4 {
    color: white;
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

.premium-feature p {
    color: #94a3b8;
    line-height: 1.6;
}

.premium-pricing {
    padding: 2rem;
    text-align: center;
    border-top: 1px solid rgba(245, 158, 11, 0.2);
    background: rgba(255, 255, 255, 0.05);
    position: sticky;
    bottom: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
}

.price-badge {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-size: 1.5rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 8px 32px rgba(245, 158, 11, 0.25);
    animation: pulseBadge 2s infinite;
}

.price-badge i {
    font-size: 1.25rem;
}

.price-period {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    font-weight: normal;
}

.btn-subscribe {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    color: white;
    border: 2px solid #f59e0b;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    width: auto;
    min-width: 200px;
    justify-content: center;
}

.btn-subscribe:hover {
    transform: translateY(-3px);
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-color: transparent;
    box-shadow: 0 15px 30px rgba(245, 158, 11, 0.3);
}

@keyframes pulseBadge {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.premium-pricing h3 {
    color: white;
    font-size: 2.5rem;
    margin-bottom: 2rem;
}

.btn-subscribe {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 1rem;
}

.btn-subscribe:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(245, 158, 11, 0.3);
}



.premium-modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(8px);
    z-index: 3000;
    justify-content: center;
    align-items: center;
}

.premium-modal {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-radius: 24px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    overflow: hidden;
    max-width: 600px; 
    width: 95%;
    max-height: 90vh;
    overflow-y: auto;
}

.premium-modal-header {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    padding: 1.5rem;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1;
}

.modal-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.25rem;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.premium-features {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
    padding: 1.5rem;
}

.premium-pricing {
    padding: 1.5rem;
    text-align: center;
    border-top: 1px solid rgba(245, 158, 11, 0.2);
    background: rgba(255, 255, 255, 0.05);
    position: sticky;
    bottom: 0;
}

.btn-subscribe {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    margin-top: 1rem;
}

.footer {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: white;
    padding: 4rem 0 2rem;
    position: relative;
    margin-top: 4rem;
}

.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
}

.footer-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 3rem;
    margin-bottom: 2rem;
}

.footer-section h3 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 2rem;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.footer-section h3::before {
    content: '';
    width: 4px;
    height: 24px;
    background: linear-gradient(to bottom, #0ea5e9, #10b981);
    border-radius: 2px;
}

.contact-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    padding: 0.5rem;
    border-radius: 8px;
}

.contact-info:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateX(5px);
    color: #0ea5e9;
}

.contact-info i {
    color: #0ea5e9;
    width: 20px;
    font-size: 1.1rem;
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 2rem;
    text-align: center;
}

.footer-bottom p {
    color: #94a3b8;
    margin: 0;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .footer {
        padding: 3rem 0 1.5rem;
    }

    .footer-container {
        padding: 0 1rem;
    }
}

.premium-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
    animation: fadeInUp 0.5s ease;
}

.premium-action-btn {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    border: 1px solid rgba(245, 158, 11, 0.3);
    padding: 1.5rem;
    border-radius: 16px;
    color: white;
    text-align: left;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.premium-action-btn:hover {
    transform: translateY(-5px);
    background: linear-gradient(135deg, #0f172a, #1e293b);
    border-color: #f59e0b;
    box-shadow: 0 15px 30px rgba(245, 158, 11, 0.2);
}

.premium-action-btn i {
    font-size: 2rem;
    color: #f59e0b;
    margin-bottom: 0.5rem;
}

.premium-action-btn span {
    font-size: 1.1rem;
    font-weight: 600;
}

.premium-action-btn small {
    color: #94a3b8;
    font-size: 0.9rem;
}

    </style>
</head>
<body data-premium="{{ auth()->user()->hasActivePremium() ? 'true' : 'false' }}">
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    
    <header class="admin-header">
    <nav class="admin-navbar">
        <a href="/" class="admin-brand">
            <div class="brand-icon">
                <i class="fas fa-tint"></i>
            </div>
            <div class="brand-text">
                <h1>Gëstu Ndox Mi</h1>
                <p class="brand-subtitle">Dashboard Administrateur</p>
            </div>
        </a>
        
        <div class="admin-actions">
            
            <div class="premium-section">
                @if(auth()->user()->hasActivePremium())
                    <span class="premium-badge">
                        <i class="fas fa-crown"></i> Premium Actif
                    </span>
                @else
                    <button onclick="showPremiumModal()" class="btn-premium">
                        <i class="fas fa-crown"></i> Passer au Premium
                    </button>
                @endif
            </div>
            
            
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>
</header>

<!-- premium modal... -->
<div class="premium-modal-overlay" id="premiumModalOverlay">
    <div class="premium-modal">
        <div class="premium-modal-header">
            <h3><i class="fas fa-crown"></i> Fonctionnalités Premium</h3>
            <button class="modal-close" onclick="closePremiumModal()">×</button>
        </div>
        
        <div class="premium-features">
            <div class="premium-feature">
                <i class="fas fa-robot"></i>
                <h4>Analyse IA</h4>
                <p>Analyse détaillée des données par notre ChatBot intégré</p>
            </div>
            <div class="premium-feature">
                <i class="fas fa-file-pdf"></i>
                <h4>Rapports PDF</h4>
                <p>Génération de rapports détaillés en PDF</p>
            </div>
            <div class="premium-feature">
                <i class="fas fa-chart-line"></i>
                <h4>Statistiques avancées</h4>
                <p>Accès aux statistiques et prévisions avancées</p>
            </div>
        </div>
        
        <div class="premium-pricing">
            <div class="price-badge">
                <i class="fas fa-crown"></i>
                5000 FCFA
                <span class="price-period">/ mois</span>
            </div>
            
            <button onclick="initializeWavePayment()" class="btn-subscribe">
                <i class="fas fa-money-bill-wave"></i>
                Payer avec Wave
            </button>
        </div>
    </div>
</div>

   
    <main class="admin-container">
        @if(session('success'))
            <div class="success-alert">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Succès !</strong><br>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- STATISTICS -->
        <div class="stats-grid">
            <div class="stat-card" style="--card-color: #ef4444; --card-color-light: #fca5a5;">
                <div class="stat-header">
                    <span class="stat-title">En attente</span>
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-value" id="stat-pending">0</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    Signalements prioritaires
                </div>
            </div>

            <div class="stat-card" style="--card-color: #f59e0b; --card-color-light: #fcd34d;">
                <div class="stat-header">
                    <span class="stat-title">En cours</span>
                    <div class="stat-icon">
                        <i class="fas fa-cog fa-spin"></i>
                    </div>
                </div>
                <div class="stat-value" id="stat-progress">0</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-right"></i>
                    Interventions actives
                </div>
            </div>

            <div class="stat-card" style="--card-color: #10b981; --card-color-light: #6ee7b7;">
                <div class="stat-header">
                    <span class="stat-title">Résolus</span>
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value" id="stat-resolved">0</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    Problèmes résolus
                </div>
            </div>

            <div class="stat-card" style="--card-color: #0ea5e9; --card-color-light: #7dd3fc;">
                <div class="stat-header">
                    <span class="stat-title">Total</span>
                    <div class="stat-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
                <div class="stat-value" id="stat-total">0</div>
                <div class="stat-trend">
                    <i class="fas fa-users"></i>
                    Signalements reçus
                </div>
            </div>
        </div>

        @if(auth()->user()->hasActivePremium())
<div class="premium-actions-grid">
    <button onclick="generatePDF()" class="premium-action-btn">
        <i class="fas fa-file-pdf"></i>
        <span>Générer Rapport PDF</span>
        <small>Export détaillé de tous les signalements</small>
    </button>
    
    <button onclick="analyzeData()" class="premium-action-btn">
        <i class="fas fa-robot"></i>
        <span>Analyse IA</span>
        <small>Analyse approfondie par notre ChatBot</small>
    </button>
    
    <button onclick="showAdvancedStats()" class="premium-action-btn">
        <i class="fas fa-chart-line"></i>
        <span>Statistiques Avancées</span>
        <small>Métriques et prévisions détaillées</small>
    </button>
</div>
@endif

        <!-- GRAPHIQUES -->
        <div class="charts-section">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-pie"></i>
                        Répartition par Type
                    </h3>
                </div>
                <div class="chart-container">
                    <canvas id="problemTypeChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-line"></i>
                        Évolution Temporelle
                    </h3>
                </div>
                <div class="chart-container">
                    <canvas id="timelineChart"></canvas>
                </div>
            </div>

            @if(auth()->user()->hasActivePremium())
        <div class="chart-card premium-chart">
            <div class="chart-header">
                <h3 class="chart-title">
                    <i class="fas fa-brain"></i>
                    Prévisions IA
                </h3>
                <span class="premium-badge">
                    <i class="fas fa-crown"></i> Premium
                </span>
            </div>
            <div class="chart-container">
                <canvas id="aiPredictionChart"></canvas>
            </div>
        </div>

        <div class="chart-card premium-chart">
            <div class="chart-header">
                <h3 class="chart-title">
                    <i class="fas fa-analytics"></i>
                    Analyse Avancée
                </h3>
                <span class="premium-badge">
                    <i class="fas fa-crown"></i> Premium
                </span>
            </div>
            <div class="chart-container">
                <canvas id="advancedAnalysisChart"></canvas>
            </div>
        </div>
    @endif
        </div>

        <div class="charts-section">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-map-marked-alt"></i>
                        Zones les Plus Touchées
                    </h3>
                </div>
                <div class="chart-container">
                    <canvas id="zonesChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-bar"></i>
                        Performance de Résolution
                    </h3>
                </div>
                <div class="chart-container">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- CARTE -->
        <div class="map-section">
            <div class="map-header">
                <h2 class="map-title">
                    <i class="fas fa-map-marked-alt"></i>
                    Carte Interactive des Signalements
                </h2>
                <p class="map-subtitle">Visualisation géographique en temps réel avec clustering intelligent</p>
            </div>
            <div id="map"></div>
        </div>

        <!-- LISTE SIGNALEMENTS -->
        <div class="table-section">
            <div class="table-header">
                <div class="table-title-section">
                    <h2 class="table-title">
                        <i class="fas fa-list-alt"></i>
                        Liste des signalements
                    </h2>
                    <p class="table-subtitle">
                        <i class="fas fa-info-circle"></i> Cliquez sur un signalement pour voir tous les détails
                    </p>
                </div>
                <div class="table-controls">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" id="searchInput" placeholder="Rechercher par nom, téléphone, adresse...">
                    </div>
                    <select class="filter-select" id="statusFilter">
                        <option value="">Tous les statuts</option>
                        <option value="en attente">En attente</option>
                        <option value="en cours">En cours</option>
                        <option value="résolu">Résolu</option>
                    </select>
                    <select class="filter-select" id="problemFilter">
                        <option value="">Tous les types</option>
                        <option value="coupure">Coupure</option>
                        <option value="penurie">Pénurie</option>
                        <option value="fuite">Fuite</option>
                        <option value="fosse">Fosse</option>
                        <option value="qualite">Qualité</option>
                    </select>
                </div>
            </div>
            
            <div class="table-container">
                <table class="reports-table" id="reportsTable">
                    <thead>
                        <tr>
                            <th style="width: 15%;" data-sort="nom">
                                <i class="fas fa-user"></i> Nom 
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th style="width: 20%;" data-sort="contact">
                                <i class="fas fa-phone"></i> Contact
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th style="width: 15%;" data-sort="type">
                                <i class="fas fa-exclamation-triangle"></i> Problème
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th style="width: 20%;" data-sort="address">
                                <i class="fas fa-map-marker-alt"></i> Adresse
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th style="width: 15%;" data-sort="status">
                                <i class="fas fa-info-circle"></i> Statut
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th style="width: 15%;">
                                <i class="fas fa-cogs"></i> Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="reportsTableBody">
                        @foreach($reports as $report)
                        <tr class="report-row" data-report-id="{{ $report->id }}" 
                            data-nom="{{ strtolower($report->nom) }}"
                            data-telephone="{{ strtolower($report->telephone ?? '') }}"
                            data-email="{{ strtolower($report->email ?? '') }}"
                            data-type="{{ $report->type_probleme }}"
                            data-status="{{ $report->statut }}"
                            data-address="{{ strtolower($report->adresse ?? '') }}"
                            data-date="{{ $report->created_at->timestamp }}">
                            <td>
                                <strong>{{ $report->nom }}</strong>
                            </td>
                            <td>
                                @if($report->telephone)
                                    <div style="font-size: 0.9rem; margin-bottom: 0.25rem;">
                                        <i class="fas fa-phone" style="color: #10b981;"></i>
                                        <strong>{{ $report->telephone }}</strong>
                                    </div>
                                @endif
                                @if($report->email)
                                    <div style="font-size: 0.85rem; color: #64748b;">
                                        <i class="fas fa-envelope"></i>
                                        {{ $report->email }}
                                    </div>
                                @endif
                                @if(!$report->telephone && !$report->email)
                                    <div style="font-size: 0.85rem; color: #64748b; font-style: italic;">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Aucun contact
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="problem-type">
                                    @switch($report->type_probleme)
                                        @case('coupure')
                                            <i class="fas fa-ban" style="color: #ef4444;"></i>
                                            @break
                                        @case('penurie')
                                            <i class="fas fa-tint" style="color: #f59e0b;"></i>
                                            @break
                                        @case('fuite')
                                            <i class="fas fa-wrench" style="color: #0ea5e9;"></i>
                                            @break
                                        @case('fosse')
                                            <i class="fas fa-home" style="color: #8b5cf6;"></i>
                                            @break
                                        @case('qualite')
                                            <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i>
                                            @break
                                        @default
                                            <i class="fas fa-question" style="color: #64748b;"></i>
                                    @endswitch
                                    {{ ucfirst($report->type_probleme) }}
                                </div>
                            </td>

                           
                            <td class="address-cell">
                                <div class="truncated-address">
                                    @if($report->adresse)
                                        {{ $report->adresse }}
                                    @elseif($report->latitude && $report->longitude)
                                        <span class="generate-address" data-lat="{{ $report->latitude }}" data-lng="{{ $report->longitude }}">
                                            <i class="fas fa-sync-alt fa-spin"></i> Chargement...
                                        </span>
                                    @else
                                        Adresse non disponible
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ str_replace(' ', '-', $report->statut) }}">
                                    @switch($report->statut)
                                        @case('en attente')
                                            <i class="fas fa-clock"></i>
                                            @break
                                        @case('en cours')
                                            <i class="fas fa-cog fa-spin"></i>
                                            @break
                                        @case('résolu')
                                            <i class="fas fa-check"></i>
                                            @break
                                    @endswitch
                                    {{ $report->statut }}
                                </span>
                            </td>
                            <td>
                                <div class="action-controls">
                                    <form method="POST" action="{{ route('admin.reports.status', $report) }}" class="status-form">
                                        @csrf
                                        <select name="statut" class="status-select" onchange="updateStatus(this)">
                                            <option value="en attente" {{ $report->statut=='en attente'?'selected':'' }}>En attente</option>
                                            <option value="en cours" {{ $report->statut=='en cours'?'selected':'' }}>En cours</option>
                                            <option value="résolu" {{ $report->statut=='résolu'?'selected':'' }}>Résolu</option>
                                        </select>
                                    </form>

                                    <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" class="delete-form" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="pagination" id="pagination">
                <!-- Pagination sera générée dynamiquement -->
            </div>
        </div>
    </main>

    <!-- Modal pour les détails du signalement -->
    <div class="report-modal-overlay" id="reportModalOverlay">
        <div class="report-modal">
            <div class="report-modal-header">
                <div class="report-modal-title">
                    <i class="fas fa-info-circle"></i>
                    <span>Détails du signalement</span>
                </div>
                <button class="report-modal-close" id="closeReportModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="report-modal-body">
                <!-- Informations personnelles -->
                <div class="report-detail-section">
                    <div class="report-detail-title">
                        <i class="fas fa-user"></i> Informations personnelles
                    </div>
                    <div class="report-detail-content">
                        <div id="reporterName">Nom: <strong>...</strong></div>
                        <div class="report-detail-meta" id="contactSection">
                            <div class="report-meta-item" id="reporterPhone">
                                <i class="fas fa-phone"></i> <span>...</span>
                            </div>
                            <div class="report-meta-item" id="reporterEmail">
                                <i class="fas fa-envelope"></i> <span>...</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Problème signalé -->
                <div class="report-detail-section">
                    <div class="report-detail-title">
                        <i class="fas fa-exclamation-triangle"></i> Problème signalé
                    </div>
                    <div class="report-detail-content">
                        <div id="problemType">Type: <strong>...</strong></div>
                        <div id="problemDescription" style="margin-top: 0.75rem;">Description: ...</div>
                    </div>
                </div>
                
                <!-- Localisation -->
                <div class="report-detail-section">
                    <div class="report-detail-title">
                        <i class="fas fa-map-marker-alt"></i> Localisation
                    </div>
                    <div class="report-detail-content">
                        <div id="reportAddress">Adresse: ...</div>
                        <div id="reportCoordinates" style="margin-top: 0.5rem; font-size: 0.85rem; color: #64748b;">Coordonnées: ...</div>
                    </div>
                </div>
                
                <!-- Statut et date -->
                <div class="report-detail-section">
                    <div class="report-detail-title">
                        <i class="fas fa-info-circle"></i> Statut et date
                    </div>
                    <div class="report-detail-content">
                        <div id="reportStatus">Statut: <span class="status-badge">...</span></div>
                        <div id="reportDate" style="margin-top: 0.5rem;">Date de signalement: ...</div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="report-detail-section">
                    <div class="report-detail-title">
                        <i class="fas fa-cogs"></i> Actions
                    </div>
                    <div class="report-detail-content" style="display: flex; gap: 1rem;">
                        <form id="statusUpdateForm" method="POST" style="flex: 1;">
                            @csrf
                            <select name="statut" class="status-select" style="width: 100%;">
                                <option value="en attente">En attente</option>
                                <option value="en cours">En cours</option>
                                <option value="résolu">Résolu</option>
                            </select>
                            <button type="submit" style="margin-top: 0.5rem; width: 100%; padding: 0.75rem; background: linear-gradient(135deg, #0ea5e9, #10b981); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                                <i class="fas fa-save"></i> Mettre à jour le statut
                            </button>
                        </form>
                        
                        <form id="deleteReportForm" method="POST" style="flex: 1;" onsubmit="return confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="width: 100%; padding: 0.75rem; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                                <i class="fas fa-trash"></i> Supprimer le signalement
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de suppression -->
    <div class="delete-modal-overlay" id="deleteModalOverlay">
        <div class="delete-modal">
            <div class="delete-modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h3 class="delete-modal-title">Confirmation de suppression</h3>
            </div>
            <div class="delete-modal-body">
                <p>Vous êtes sur le point de supprimer définitivement ce signalement.</p>
                <div class="delete-modal-warning">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Attention :</strong> Cette action est irréversible et supprimera toutes les données associées à ce signalement.
                    </div>
                </div>
            </div>
            <div class="delete-modal-actions">
                <button class="btn-cancel" id="cancelDelete">
                    Annuler
                </button>
                <button class="btn-confirm-delete" id="confirmDelete">
                    <i class="fas fa-trash-alt"></i>
                    Confirmer la suppression
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Premium -->
    <div class="premium-modal-overlay" id="premiumModalOverlay">
    <div class="premium-modal">
        <div class="premium-modal-header">
            <h3><i class="fas fa-crown"></i> Fonctionnalités Premium</h3>
            <button class="modal-close" onclick="closePremiumModal()">×</button>
        </div>
        
        <div class="premium-features">
            <div class="premium-feature">
                <i class="fas fa-robot"></i>
                <h4>Analyse IA</h4>
                <p>Analyse détaillée des données par notre ChatBot intégré</p>
            </div>
            <div class="premium-feature">
                <i class="fas fa-file-pdf"></i>
                <h4>Rapports PDF</h4>
                <p>Génération de rapports détaillés en PDF</p>
            </div>
            <div class="premium-feature">
                <i class="fas fa-chart-line"></i>
                <h4>Statistiques avancées</h4>
                <p>Accès aux statistiques et prévisions avancées</p>
            </div>
        </div>
        
        <div class="premium-pricing">
            <div class="price-badge">
                <i class="fas fa-crown"></i>
                5000 FCFA
                <span class="price-period">/ mois</span>
            </div>
            
            <button onclick="initializeWavePayment()" class="btn-subscribe">
                <i class="fas fa-money-bill-wave"></i>
                Payer avec Wave
            </button>
        </div>
    </div>
</div>

    <footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Gëstu Ndox Mi - Administration</h3>
                <p style="color: #cbd5e1; line-height: 1.6; margin-bottom: 1.5rem;">
                    Espace administrateur dédié à la gestion et au suivi des signalements de problèmes liés aux points d'eau au Sénégal. Visualisez, analysez et intervenez efficacement pour garantir un meilleur accès à l'eau.
                </p>
                <div class="contact-info">
                    <i class="fas fa-chart-line"></i>
                    <span>Tableau de bord en temps réel</span>
                </div>
            </div>

            <div class="footer-section">
                <h3>Outils Administrateur</h3>
                <div class="contact-info">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Carte interactive des signalements</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-chart-bar"></i>
                    <span>Statistiques détaillées</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-tasks"></i>
                    <span>Gestion des statuts</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-bell"></i>
                    <span>Reception signalements instantanée</span>
                </div>
            </div>

            <div class="footer-section">
                <h3>Support Technique</h3>
                <div class="contact-info">
                    <i class="fas fa-envelope"></i>
                    <span>support@gestundoxmi.sn</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-clock"></i>
                    <span>Disponible 24h/24, 7j/7</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-shield-alt"></i>
                    <span>Accès sécurisé</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-database"></i>
                    <span>Sauvegarde automatique</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Gëstu Ndox Mi - Interface d'administration. Tous droits réservés.</p>
        </div>
    </div>
</footer>

   

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

    <script>
        // Configuration globale et données
        const CONFIG = {
            itemsPerPage: 10,
            currentPage: 1,
            allReports: [],
            filteredReports: [],
            sortColumn: null,
            sortDirection: 'asc'
        };

        
        function formatReportData(report) {
            return {
                id: report.id,
                nom: report.nom,
                telephone: report.telephone || '',
                email: report.email || '',
                type_probleme: report.type_probleme,
                description: report.description || 'Aucune description',
                adresse: report.adresse || '',
                latitude: report.latitude || '',
                longitude: report.longitude || '',
                statut: report.statut,
                created_at: report.created_at
            };
        }

        // Initialisation des données
        const reportsData = {
            @foreach($reports as $report)
            {{ $report->id }}: {
                id: {{ $report->id }},
                nom: "{{ $report->nom }}",
                telephone: "{{ $report->telephone ?: '' }}",
                email: "{{ $report->email ?: '' }}",
                type_probleme: "{{ $report->type_probleme }}",
                description: "{{ $report->description ?: 'Aucune description' }}",
                adresse: "{{ $report->adresse ?: '' }}",
                latitude: "{{ $report->latitude ?: '' }}",
                longitude: "{{ $report->longitude ?: '' }}",
                statut: "{{ $report->statut }}",
                created_at: "{{ $report->created_at->format('d/m/Y à H:i') }}"
            },
            @endforeach
        };

        
        const addressCache = new Map();

        // Utilitaires
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        function showSuccess(message) {
            const alert = document.createElement('div');
            alert.className = 'success-alert';
            alert.innerHTML = `<i class="fas fa-check-circle"></i><div><strong>Succès !</strong><br>${message}</div>`;
            document.querySelector('.admin-container').insertBefore(alert, document.querySelector('.stats-grid'));
            setTimeout(() => alert.remove(), 5000);
        }

        function confirmDelete(event) {
            event.preventDefault();
            const deleteForm = event.target;
            const deleteModalOverlay = document.getElementById('deleteModalOverlay');
            const cancelDeleteBtn = document.getElementById('cancelDelete');
            const confirmDeleteBtn = document.getElementById('confirmDelete');

            deleteModalOverlay.style.display = 'flex';
            
            cancelDeleteBtn.onclick = () => {
                deleteModalOverlay.style.display = 'none';
            };
            
            confirmDeleteBtn.onclick = () => {
                deleteForm.submit();
            };

            deleteModalOverlay.onclick = (e) => {
                if (e.target === deleteModalOverlay) {
                    deleteModalOverlay.style.display = 'none';
                }
            };

            return false;
        }

        
        setTimeout(() => {
            const confirmBtn = document.getElementById('confirmDelete');
            if (confirmBtn) {
                confirmBtn.style.animation = 'shake 0.5s ease';
            }
        }, 3000);

        // Fonction pour générer les adresses
        async function generateAddress(lat, lng, element) {
            const cacheKey = `${lat},${lng}`;
            
            if (addressCache.has(cacheKey)) {
                element.textContent = addressCache.get(cacheKey);
                return;
            }

            try {
                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
                const response = await fetch(url);
                const data = await response.json();
                
                if (data && data.display_name) {
                    const address = data.display_name;
                    addressCache.set(cacheKey, address);
                    element.textContent = address;
                } else {
                    element.textContent = 'Adresse non disponible';
                }
            } catch (error) {
                console.error('Erreur géocodage:', error);
                element.textContent = 'Erreur de géocodage';
            }
        }

        
        async function updateStatus(selectElement) {
            const form = selectElement.closest('form');
            const formData = new FormData(form);
            
            showLoading();
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    showSuccess('Statut mis à jour avec succès');
                    // Mettre à jour l'affichage du badge
                    const row = selectElement.closest('tr');
                    const badge = row.querySelector('.status-badge');
                    const newStatus = selectElement.value;
                    
                    // Mettre à jour les classes et le contenu
                    badge.className = `status-badge status-${newStatus.replace(' ', '-')}`;
                    badge.innerHTML = `
                        ${newStatus === 'en attente' ? '<i class="fas fa-clock"></i>' : 
                          newStatus === 'en cours' ? '<i class="fas fa-cog fa-spin"></i>' : 
                          '<i class="fas fa-check"></i>'}
                        ${newStatus}
                    `;
                    
                    // Mettre à jour les statistiques
                    updateStatistics();
                    
                    // Mettre à jour les données locales
                    row.dataset.status = newStatus;
                    const reportId = row.dataset.reportId;
                    if (reportsData[reportId]) {
                        reportsData[reportId].statut = newStatus;
                    }
                } else {
                    throw new Error('Erreur serveur');
                }
            } catch (error) {
                console.error('Erreur mise à jour:', error);
                alert('Erreur lors de la mise à jour du statut');
            } finally {
                hideLoading();
            }
        }

        // Fonction pour mettre à jour les statistiques en temps réel
        function updateStatistics() {
            const rows = document.querySelectorAll('#reportsTableBody tr:not([style*="display: none"])');
            let pending = 0, progress = 0, resolved = 0;
            
            rows.forEach(row => {
                const status = row.dataset.status;
                switch(status) {
                    case 'en attente': pending++; break;
                    case 'en cours': progress++; break;
                    case 'résolu': resolved++; break;
                }
            });
            
            // Animation des compteurs
            animateCounter('stat-pending', pending);
            animateCounter('stat-progress', progress);
            animateCounter('stat-resolved', resolved);
            animateCounter('stat-total', rows.length);
        }

        function animateCounter(elementId, target) {
            const element = document.getElementById(elementId);
            const current = parseInt(element.textContent);
            
            if (current === target) return;
            
            const increment = target > current ? 1 : -1;
            const timer = setInterval(() => {
                const value = parseInt(element.textContent);
                if (value === target) {
                    clearInterval(timer);
                } else {
                    element.textContent = value + increment;
                }
            }, 50);
        }

        // Système de recherche et filtrage
        function initializeTableFeatures() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const problemFilter = document.getElementById('problemFilter');
            const tableBody = document.getElementById('reportsTableBody');
            
            // Récupérer toutes les lignes
            CONFIG.allReports = Array.from(tableBody.querySelectorAll('tr'));
            CONFIG.filteredReports = [...CONFIG.allReports];
            
            // Recherche
            searchInput.addEventListener('input', debounce(performSearch, 300));
            statusFilter.addEventListener('change', performSearch);
            problemFilter.addEventListener('change', performSearch);
            
            // Tri des colonnes
            document.querySelectorAll('th[data-sort]').forEach(th => {
                th.addEventListener('click', () => sortTable(th.dataset.sort, th));
                th.style.cursor = 'pointer';
            });
            
            // Initialiser la pagination
            updatePagination();
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const problemFilter = document.getElementById('problemFilter').value;
            
            CONFIG.filteredReports = CONFIG.allReports.filter(row => {
                const matchesSearch = !searchTerm || 
                    row.dataset.nom.includes(searchTerm) ||
                    row.dataset.telephone.includes(searchTerm) ||
                    row.dataset.email.includes(searchTerm) ||
                    row.dataset.address.includes(searchTerm);
                    
                const matchesStatus = !statusFilter || row.dataset.status === statusFilter;
                const matchesType = !problemFilter || row.dataset.type === problemFilter;
                
                return matchesSearch && matchesStatus && matchesType;
            });
            
            CONFIG.currentPage = 1;
            updatePagination();
            updateStatistics();
        }

        function sortTable(column, headerElement) {
            
            document.querySelectorAll('.sort-icon').forEach(icon => {
                icon.className = 'fas fa-sort sort-icon';
            });
            
            if (CONFIG.sortColumn === column) {
                CONFIG.sortDirection = CONFIG.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                CONFIG.sortColumn = column;
                CONFIG.sortDirection = 'asc';
            }
            
            const sortIcon = headerElement.querySelector('.sort-icon');
            sortIcon.className = `fas fa-sort-${CONFIG.sortDirection === 'asc' ? 'up' : 'down'} sort-icon`;
            
            CONFIG.filteredReports.sort((a, b) => {
                let aValue, bValue;
                
                switch(column) {
                    case 'nom':
                        aValue = a.dataset.nom;
                        bValue = b.dataset.nom;
                        break;
                    case 'type':
                        aValue = a.dataset.type;
                        bValue = b.dataset.type;
                        break;
                    case 'status':
                        aValue = a.dataset.status;
                        bValue = b.dataset.status;
                        break;
                    case 'address':
                        aValue = a.dataset.address;
                        bValue = b.dataset.address;
                        break;
                    case 'contact':
                        aValue = a.dataset.telephone || a.dataset.email;
                        bValue = b.dataset.telephone || b.dataset.email;
                        break;
                    default:
                        return 0;
                }
                
                if (CONFIG.sortDirection === 'asc') {
                    return aValue.localeCompare(bValue);
                } else {
                    return bValue.localeCompare(aValue);
                }
            });
            
            updatePagination();
        }

        function updatePagination() {
            const totalItems = CONFIG.filteredReports.length;
            const totalPages = Math.ceil(totalItems / CONFIG.itemsPerPage);
            const startIndex = (CONFIG.currentPage - 1) * CONFIG.itemsPerPage;
            const endIndex = startIndex + CONFIG.itemsPerPage;
            
            
            CONFIG.allReports.forEach(row => row.style.display = 'none');
            
          
            CONFIG.filteredReports.slice(startIndex, endIndex).forEach(row => {
                row.style.display = '';
            });
            
            // Générer la pagination
            generatePaginationControls(totalPages);
        }

        function generatePaginationControls(totalPages) {
            const paginationContainer = document.getElementById('pagination');
            paginationContainer.innerHTML = '';
            
            if (totalPages <= 1) return;
            
            // Bouton précédent
            const prevBtn = document.createElement('button');
            prevBtn.className = `pagination-btn ${CONFIG.currentPage === 1 ? 'disabled' : ''}`;
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevBtn.disabled = CONFIG.currentPage === 1;
            prevBtn.onclick = () => changePage(CONFIG.currentPage - 1);
            paginationContainer.appendChild(prevBtn);
            
            // Numéros de page
            const maxVisible = 5;
            let startPage = Math.max(1, CONFIG.currentPage - Math.floor(maxVisible / 2));
            let endPage = Math.min(totalPages, startPage + maxVisible - 1);
            
            if (endPage - startPage < maxVisible - 1) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `pagination-btn ${i === CONFIG.currentPage ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.onclick = () => changePage(i);
                paginationContainer.appendChild(pageBtn);
            }
            
            // Bouton suivant
            const nextBtn = document.createElement('button');
            nextBtn.className = `pagination-btn ${CONFIG.currentPage === totalPages ? 'disabled' : ''}`;
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextBtn.disabled = CONFIG.currentPage === totalPages;
            nextBtn.onclick = () => changePage(CONFIG.currentPage + 1);
            paginationContainer.appendChild(nextBtn);
            
            // Info pagination
            const info = document.createElement('div');
            info.style.cssText = 'margin-left: 1rem; color: #64748b; font-size: 0.9rem;';
            const start = (CONFIG.currentPage - 1) * CONFIG.itemsPerPage + 1;
            const end = Math.min(CONFIG.currentPage * CONFIG.itemsPerPage, CONFIG.filteredReports.length);
            info.textContent = `${start}-${end} sur ${CONFIG.filteredReports.length} signalements`;
            paginationContainer.appendChild(info);
        }

        function changePage(page) {
            CONFIG.currentPage = page;
            updatePagination();
        }

        // Gestion de la modal
        async function openReportModal(reportId) {
            showLoading();
            
            try {
                const reportData = reportsData[reportId];
                if (!reportData) throw new Error('Données non trouvées');
                
                populateModal(reportData);
                document.getElementById('reportModalOverlay').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } catch (error) {
                console.error('Erreur ouverture modal:', error);
                alert('Erreur lors du chargement des détails');
            } finally {
                hideLoading();
            }
        }

        function populateModal(report) {
            // Informations personnelles
            document.getElementById('reporterName').innerHTML = `Nom: <strong>${report.nom}</strong>`;
            
            const contactSection = document.getElementById('contactSection');
            contactSection.innerHTML = '';
            
            if (report.telephone) {
                const phoneDiv = document.createElement('div');
                phoneDiv.className = 'report-meta-item';
                phoneDiv.innerHTML = `<i class="fas fa-phone" style="color: #10b981;"></i><span>${report.telephone}</span>`;
                contactSection.appendChild(phoneDiv);
            }
            
            if (report.email) {
                const emailDiv = document.createElement('div');
                emailDiv.className = 'report-meta-item';
                emailDiv.innerHTML = `<i class="fas fa-envelope"></i><span>${report.email}</span>`;
                contactSection.appendChild(emailDiv);
            }
            
            if (!report.telephone && !report.email) {
                const noContactDiv = document.createElement('div');
                noContactDiv.className = 'report-meta-item';
                noContactDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i><span>Aucun contact disponible</span>`;
                noContactDiv.style.fontStyle = 'italic';
                contactSection.appendChild(noContactDiv);
            }
            
            // Problème
            document.getElementById('problemType').innerHTML = `Type: <strong>${report.type_probleme.charAt(0).toUpperCase() + report.type_probleme.slice(1)}</strong>`;
            document.getElementById('problemDescription').textContent = `Description: ${report.description || 'Aucune description'}`;
            
            // Localisation
            if (report.adresse) {
                document.getElementById('reportAddress').textContent = `Adresse: ${report.adresse}`;
            } else if (report.latitude && report.longitude) {
                document.getElementById('reportAddress').innerHTML = `Adresse: <i class="fas fa-sync-alt fa-spin"></i> Chargement...`;
                generateAddress(report.latitude, report.longitude, document.getElementById('reportAddress'));
            } else {
                document.getElementById('reportAddress').textContent = 'Adresse: Non disponible';
            }
            
            if (report.latitude && report.longitude) {
                document.getElementById('reportCoordinates').textContent = `Coordonnées: ${report.latitude}, ${report.longitude}`;
                document.getElementById('reportCoordinates').style.display = 'block';
            } else {
                document.getElementById('reportCoordinates').style.display = 'none';
            }
            
            // Statut et date
            const statusClass = `status-${report.statut.replace(' ', '-')}`;
            const statusIcon = report.statut === 'en attente' ? '<i class="fas fa-clock"></i>' : 
                             report.statut === 'en cours' ? '<i class="fas fa-cog fa-spin"></i>' : 
                             '<i class="fas fa-check"></i>';
            document.getElementById('reportStatus').innerHTML = `Statut: <span class="status-badge ${statusClass}">${statusIcon} ${report.statut}</span>`;
            document.getElementById('reportDate').textContent = `Date de signalement: ${report.created_at}`;
            
            // Formulaires d'action
            document.getElementById('statusUpdateForm').action = `/admin/reports/${report.id}/status`;
            document.getElementById('statusUpdateForm').querySelector('select').value = report.statut;
            document.getElementById('deleteReportForm').action = `/admin/reports/${report.id}`;
        }

        // Configuration des graphique
        function initializeCharts() {
            initializeProblemTypeChart();
            initializeTimelineChart();
            initializeZonesChart();
            initializePerformanceChart();
        }

        function initializeProblemTypeChart() {
            const ctx = document.getElementById('problemTypeChart').getContext('2d');
            
            // Calculer les données depuis les données réelles
            const problemData = {};
            Object.values(reportsData).forEach(report => {
                const type = report.type_probleme;
                problemData[type] = (problemData[type] || 0) + 1;
            });
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(problemData).map(key => key.charAt(0).toUpperCase() + key.slice(1)),
                    datasets: [{
                        data: Object.values(problemData),
                        backgroundColor: [
                            '#ef4444',
                            '#f59e0b',
                            '#0ea5e9',
                            '#8b5cf6',
                            '#10b981'
                        ],
                        borderWidth: 0,
                        hoverBorderWidth: 4,
                        hoverBorderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    family: 'Inter',
                                    size: 12,
                                    weight: 500
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#0ea5e9',
                            borderWidth: 1
                        }
                    },
                    animation: {
                        animateRotate: true,
                        duration: 2000
                    }
                }
            });
        }

        function initializeTimelineChart() {
    const ctx = document.getElementById('timelineChart').getContext('2d');
    
    // Analyser les signalements par jour sur les 7 derniers jours
    const last7Days = [];
    const today = new Date();
    
    for (let i = 6; i >= 0; i--) {
        const date = new Date(today);
        date.setDate(date.getDate() - i);
        const dateStr = date.toLocaleDateString('fr-FR', { weekday: 'short', day: 'numeric' });
        
        let pending = 0, progress = 0, resolved = 0;
        
        Object.values(reportsData).forEach(report => {
            // Convertir la date du signalement en objet Date
            const reportDate = new Date(report.created_at.split(' à')[0].split('/').reverse().join('-'));
            
            if (reportDate.toDateString() === date.toDateString()) {
                switch(report.statut) {
                    case 'en attente': pending++; break;
                    case 'en cours': progress++; break;
                    case 'résolu': resolved++; break;
                }
            }
        });
        
        last7Days.push({
            date: dateStr,
            pending,
            progress,
            resolved
        });
    }
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: last7Days.map(d => d.date),
            datasets: [
                {
                    label: 'En attente',
                    data: last7Days.map(d => d.pending),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'En cours',
                    data: last7Days.map(d => d.progress),
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Résolus',
                    data: last7Days.map(d => d.resolved),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            family: 'Inter',
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    padding: 12,
                    mode: 'index',
                    intersect: false,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y} signalement(s)`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        font: {
                            family: 'Inter'
                        }
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Inter'
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            elements: {
                point: {
                    radius: 4,
                    hoverRadius: 6
                }
            },
            animation: {
                duration: 2000
            }
        }
    });
}

        function initializeZonesChart() {
    const ctx = document.getElementById('zonesChart').getContext('2d');
    
    // Définir les départements de Dakar
    const departments = {
        'Dakar': 0,
        'Pikine': 0,
        'Guédiawaye': 0,
        'Rufisque': 0,
        'Keur Massar': 0
    };

    // Analyser les signalements par département
    Object.values(reportsData).forEach(report => {
        const address = report.adresse?.toLowerCase() || '';
        
        // Logique de classification par département
        if (address.includes('dakar') || address.includes('médina') || address.includes('plateau')) {
            departments['Dakar']++;
        } else if (address.includes('pikine') || address.includes('thiaroye')) {
            departments['Pikine']++;
        } else if (address.includes('guédiawaye') || address.includes('guediawaye')) {
            departments['Guédiawaye']++;
        } else if (address.includes('rufisque') || address.includes('bargny')) {
            departments['Rufisque']++;
        } else if (address.includes('keur massar') || address.includes('malika')) {
            departments['Keur Massar']++;
        } else {
            // Si l'adresse ne correspond à aucun département, l'ajouter à Dakar par défaut
            departments['Dakar']++;
        }
    });

    // graphique...
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(departments),
            datasets: [{
                label: 'Nombre de signalements',
                data: Object.values(departments),
                backgroundColor: [
                    'rgba(14, 165, 233, 0.8)',  
                    'rgba(245, 158, 11, 0.8)',  
                    'rgba(16, 185, 129, 0.8)',  
                    'rgba(139, 92, 246, 0.8)',  
                    'rgba(239, 68, 68, 0.8)'    
                ],
                borderColor: [
                    'rgb(14, 165, 233)',
                    'rgb(245, 158, 11)',
                    'rgb(16, 185, 129)',
                    'rgb(139, 92, 246)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 1,
                borderRadius: 6,
                maxBarThickness: 50  // Limite la largeur maximale des barres
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false  
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} signalement(s)`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        font: {
                            family: 'Inter'
                        }
                    },
                    grid: {
                        display: true,
                        color: 'rgba(148, 163, 184, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            family: 'Inter',
                            weight: '500'
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

        function initializePerformanceChart() {
            const ctx = document.getElementById('performanceChart').getContext('2d');
            
            // Calculer les performances réelles
            const totalReports = Object.values(reportsData).length;
            const resolvedReports = Object.values(reportsData)
                .filter(r => r.statut === 'résolu').length;
            const progressReports = Object.values(reportsData)
                .filter(r => r.statut === 'en cours').length;
            const pendingReports = Object.values(reportsData)
                .filter(r => r.statut === 'en attente').length;
                
            const performance = {
                'Cette semaine': {
                    target: Math.max(totalReports, 20),
                    achieved: resolvedReports + progressReports
                },
                'Objectif mensuel': {
                    target: Math.max(totalReports * 2, 50), 
                    achieved: resolvedReports
                },
                'Réactivité': {
                    target: totalReports,
                    achieved: totalReports - pendingReports
                }
            };

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(performance),
                    datasets: [
                        {
                            label: 'Objectif',
                            data: Object.values(performance).map(p => p.target),
                            backgroundColor: 'rgba(148, 163, 184, 0.5)'
                        },
                        {
                            label: 'Réalisé',
                            data: Object.values(performance).map(p => p.achieved),
                            backgroundColor: 'rgba(16, 185, 129, 0.8)'
                        }
                    ]
                }
            });
        }

        // Configuration de la carte avec clustering
        function initializeMap() {
            // Configuration de la carte
            const map = L.map('map').setView([14.6928, -17.4467], 12);

            // Thème de carte
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Groupe de clustering pour les marqueurs
            const markers = L.markerClusterGroup({
                chunkedLoading: true,
                maxClusterRadius: 60,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                iconCreateFunction: function(cluster) {
                    const childCount = cluster.getChildCount();
                    let className = 'marker-cluster-';
                    
                    if (childCount < 10) {
                        className += 'small';
                    } else if (childCount < 20) {
                        className += 'medium';
                    } else {
                        className += 'large';
                    }
                    
                    return new L.DivIcon({
                        html: `<div><span>${childCount}</span></div>`,
                        className: 'marker-cluster ' + className,
                        iconSize: new L.Point(40, 40)
                    });
                }
            });

            // Fonction pour obtenir la couleur du marqueur selon le statut
            function getMarkerColor(status) {
                switch(status) {
                    case 'en attente': return '#ef4444';
                    case 'en cours': return '#f59e0b';
                    case 'résolu': return '#10b981';
                    default: return '#64748b';
                }
            }

            // Fonction pour obtenir l'icône selon le type de problème
            function getProblemIcon(type) {
                switch(type) {
                    case 'coupure': return '🚱';
                    case 'penurie': return '💧';
                    case 'fuite': return '🔧';
                    case 'fosse': return '🏠';
                    case 'qualite': return '⚠️';
                    default: return '❓';
                }
            }

            // Ajouter les marqueurs avec coordonnées réelles ou simulées
            const reportsWithCoords = [];
            Object.values(reportsData).forEach(reportData => {
                let lat, lng;
                
                if (reportData.latitude && reportData.longitude) {
                    lat = parseFloat(reportData.latitude);
                    lng = parseFloat(reportData.longitude);
                } else {
                    // Coordonnées simulées autour de Dakar si pas de coordonnées
                    lat = 14.6928 + (Math.random() - 0.5) * 0.1;
                    lng = -17.4467 + (Math.random() - 0.5) * 0.1;
                }
                
                const marker = L.circleMarker([lat, lng], {
                    color: getMarkerColor(reportData.statut),
                    fillColor: getMarkerColor(reportData.statut),
                    fillOpacity: 0.7,
                    radius: 10,
                    weight: 3
                });

                const popupContent = `
                    <div style="font-family: 'Inter', sans-serif; min-width: 250px;">
                        <div style="background: linear-gradient(135deg, #0ea5e9, #10b981); color: white; padding: 1rem; margin: -1rem -1rem 1rem -1rem; border-radius: 8px 8px 0 0;">
                            <h4 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                <span style="font-size: 1.2rem;">${getProblemIcon(reportData.type_probleme)}</span>
                                ${reportData.nom}
                            </h4>
                            <small style="opacity: 0.9;">${reportData.type_probleme.charAt(0).toUpperCase() + reportData.type_probleme.slice(1)}</small>
                        </div>
                        
                        ${reportData.adresse ? `
                        <div style="margin-bottom: 0.75rem;">
                            <strong style="color: #374151;">📍 Adresse :</strong><br>
                            <span style="color: #64748b; font-size: 0.9rem;">${reportData.adresse}</span>
                        </div>
                        ` : ''}
                        
                        ${reportData.description && reportData.description !== 'Aucune description' ? `
                        <div style="margin-bottom: 0.75rem;">
                            <strong style="color: #374151;">📝 Description :</strong><br>
                            <span style="color: #64748b; font-size: 0.9rem;">${reportData.description.length > 100 ? reportData.description.substring(0, 100) + '...' : reportData.description}</span>
                        </div>
                        ` : ''}
                        
                        ${reportData.telephone ? `
                        <div style="margin-bottom: 0.75rem;">
                            <strong style="color: #374151;">📞 Contact :</strong><br>
                            <span style="color: #64748b; font-size: 0.9rem;">${reportData.telephone}</span>
                        </div>
                        ` : ''}
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid #e5e7eb;">
                            <span style="padding: 0.25rem 0.75rem; background: ${getMarkerColor(reportData.statut)}20; color: ${getMarkerColor(reportData.statut)}; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                ${reportData.statut.toUpperCase()}
                            </span>
                            <button onclick="openReportModal(${reportData.id})" style="background: #0ea5e9; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.8rem; cursor: pointer;">
                                Voir détails
                            </button>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);

                // Effets hover
                marker.on('mouseover', function() {
                    this.setRadius(12);
                    this.setStyle({weight: 4});
                });

                marker.on('mouseout', function() {
                    this.setRadius(10);
                    this.setStyle({weight: 3});
                });

                markers.addLayer(marker);
                reportsWithCoords.push({marker, data: reportData});
            });

            map.addLayer(markers);

            // Auto-ajustement si des marqueurs existent
            if (reportsWithCoords.length > 0) {
                map.fitBounds(markers.getBounds().pad(0.1));
            }

            return { map, markers, reportsWithCoords };
        }

        // Calculer et afficher les statistiques initiales
        function calculateInitialStats() {
            const stats = {
                pending: 0,
                progress: 0,
                resolved: 0,
                total: 0
            };
            
            Object.values(reportsData).forEach(report => {
                stats.total++;
                switch(report.statut) {
                    case 'en attente': stats.pending++; break;
                    case 'en cours': stats.progress++; break;
                    case 'résolu': stats.resolved++; break;
                }
            });
            
            // Animation des statistiques au chargement
            setTimeout(() => {
                animateCounter('stat-pending', stats.pending);
                animateCounter('stat-progress', stats.progress);
                animateCounter('stat-resolved', stats.resolved);
                animateCounter('stat-total', stats.total);
            }, 500);
        }

        // Initialisation au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initialisation du Dashboard Admin...');
            
            // Calculer et afficher les statistiques
            calculateInitialStats();
            
            // Initialiser toutes les fonctionnalités
            initializeTableFeatures();
            initializeCharts();
            const { map, markers } = initializeMap();
            
            // Gestion de la modal
            const reportRows = document.querySelectorAll('.report-row');
            const modalOverlay = document.getElementById('reportModalOverlay');
            const closeModalBtn = document.getElementById('closeReportModal');
            
            // Ouvrir la modal au clic sur une ligne
            reportRows.forEach(row => {
                row.addEventListener('click', function(e) {
                    if (e.target.tagName === 'BUTTON' || e.target.tagName === 'SELECT' || 
                        e.target.closest('button') || e.target.closest('select') || e.target.closest('form')) {
                        return;
                    }
                    
                    const reportId = this.dataset.reportId;
                    openReportModal(reportId);
                });
            });
            
            // Fermer la modal
            closeModalBtn.addEventListener('click', function() {
                modalOverlay.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
            
            modalOverlay.addEventListener('click', function(e) {
                if (e.target === modalOverlay) {
                    modalOverlay.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });

            // Générer les adresses manquantes
            document.querySelectorAll('.generate-address').forEach(element => {
                const lat = element.dataset.lat;
                const lng = element.dataset.lng;
                if (lat && lng) {
                    generateAddress(lat, lng, element);
                }
            });

            document.querySelectorAll('.full-address-content').forEach(element => {
                const lat = element.dataset.lat;
                const lng = element.dataset.lng;
                if (lat && lng) {
                    generateAddress(lat, lng, element);
                }
            });

            console.log('Dashboard Admin Gëstu Ndox Mi initialisé avec succès !');
        });

        // Rendre la fonction openReportModal globale pour les popups de carte
        window.openReportModal = openReportModal;

        
        //premium...

        function showPremiumModal() {
            const modal = document.getElementById('premiumModalOverlay');
            document.body.style.overflow = 'hidden';
            modal.style.display = 'flex';
            modal.querySelector('.premium-modal').classList.add('modal-fade-in');
        }

        function closePremiumModal() {
            const modal = document.getElementById('premiumModalOverlay');
            document.body.style.overflow = 'auto';
            modal.querySelector('.premium-modal').classList.remove('modal-fade-in');
            modal.style.display = 'none';
        }

        // Ajoutez cet écouteur d'événements
        document.getElementById('premiumModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closePremiumModal();
            }
        });

        async function initializeWavePayment() {
    try {
        showLoading();
        const response = await fetch('/subscription/initialize', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();
        
        if (data.success && data.payment_url) {
            console.log('Redirection vers Wave:', data.payment_url);
            window.location.href = data.payment_url;
        } else {
            throw new Error(data.message || 'Erreur lors de l\'initialisation du paiement');
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue lors de l\'initialisation du paiement');
    } finally {
        hideLoading();
    }
}

        async function generatePDF() {
            try {
                showLoading();
                const response = await fetch('/premium/reports/pdf', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Accès Premium requis');

                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `rapport-gestundoxmi-${new Date().toISOString().split('T')[0]}.pdf`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la génération du PDF');
            } finally {
                hideLoading();
            }
        }

        async function analyzeData() {
            try {
                showLoading();
                const response = await fetch('/premium/reports/analyze', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Accès Premium requis');

                const data = await response.json();
                showAnalysisModal(data.analysis);
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de l\'analyse');
            } finally {
                hideLoading();
            }
        }

        function initializePremiumFeatures() {
            if (!document.querySelector('[data-premium="true"]')) return;

            // Initialiser les graphiques premium
            initializeAIPredictions();
            initializeAdvancedAnalysis();
        }

        function initializeAIPredictions() {
            const ctx = document.getElementById('aiPredictionChart')?.getContext('2d');
            if (!ctx) return;

            // Configuration du graphique de prévisions...
        }

        function initializeAdvancedAnalysis() {
            const ctx = document.getElementById('advancedAnalysisChart')?.getContext('2d');
            if (!ctx) return;

            // Configuration du graphique d'analyse avancée...
        }
    </script>
</body>
</html>