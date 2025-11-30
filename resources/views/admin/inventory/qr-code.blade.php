<!DOCTYPE html>
<html>
<head>
    <title>QR Code - {{ $inventory->asset_tag }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background-color: #f5f5f5;
        }
        .qr-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
        }
        h1 {
            color: #1a7a4a;
            margin-bottom: 10px;
        }
        .asset-tag {
            font-size: 24px;
            font-weight: bold;
            color: #d4a836;
            margin-bottom: 30px;
        }
        .qr-image {
            background: white;
            padding: 20px;
            border: 2px solid #1a7a4a;
            display: inline-block;
            margin: 20px 0;
        }
        .qr-image svg {
            width: 300px;
            height: 300px;
        }
        .asset-info {
            margin-top: 20px;
            text-align: left;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .asset-info p {
            margin: 5px 0;
        }
        .print-btn {
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #1a7a4a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        .print-btn:hover {
            background-color: #156839;
        }
        @media print {
            body {
                background-color: white;
            }
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <h1>Asset QR Code</h1>
        <div class="asset-tag">{{ $inventory->asset_tag }}</div>
        <div class="qr-image">
            {!! $qrCode !!}
        </div>
        <div class="asset-info">
            <p><strong>Item:</strong> {{ $inventory->item_name }}</p>
            <p><strong>Category:</strong> {{ $inventory->category->name ?? 'N/A' }}</p>
            <p><strong>Serial:</strong> {{ $inventory->serial_number ?? 'N/A' }}</p>
            <p><strong>Generated on:</strong> {{ now()->format('F d, Y \a\t g:i A') }}</p>
        </div>
    </div>
    <button class="print-btn" onclick="window.print()">🖨️ Print QR Code</button>
</body>
</html>