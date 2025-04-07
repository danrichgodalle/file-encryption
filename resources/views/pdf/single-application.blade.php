<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .application-details {
            margin-bottom: 20px;
        }
        .detail-row {
            margin-bottom: 10px;
            padding: 5px;
            border-bottom: 1px solid #eee;
            word-wrap: break-word;
        }
        .label {
            font-weight: bold;
            margin-right: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        .photo-container {
            text-align: center;
            margin: 20px 0;
        }
        .photo-container img {
            max-width: 200px;
            height: auto;
            border: 1px solid #ddd;
            object-fit: cover;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .value {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .properties-list {
            list-style-type: none;
            padding: 0;
        }
        .properties-list li {
            margin-bottom: 5px;
        }
        .no-data {
            color: #999;
            font-style: italic;
        }
        .status-section {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-declined {
            background-color: #f8d7da;
            color: #721c24;
        }
        .decline-reason {
            margin-top: 10px;
            padding: 10px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <div class="application-details">
        <div class="section">
            <div class="section-title">Personal Information</div>
            <div class="detail-row">
               
                <span class="value">{{ $application->name }}</span>
            </div>
            <div class="detail-row">
             
                <span class="value">{{ $application->nick_name }}</span>
            </div>
            <div class="detail-row">
            
                <span class="value">{{ $application->address }}</span>
            </div>
            <div class="detail-row">
              
                <span class="value">{{ $application->tel_no }}</span>
            </div>
            <div class="detail-row">
              
                <span class="value">{{ $application->cell_no }}</span>
            </div>
            <div class="detail-row">
               
                <span class="value">{{ $application->length_of_stay }}</span>
            </div>
            <div class="detail-row">
               
                <span class="value">{{ $application->ownership }}</span>
            </div>
            <div class="detail-row">
               
                <span class="value">{{ $application->rent_amount }}</span>
            </div>
        </div>

        <div class="section">
    
            <div class="detail-row">
                
                <span class="value">{{ $application->date_of_birth }}</span>
            </div>
            <div class="detail-row">
               
                <span class="value">{{ $application->place_of_birth }}</span>
            </div>
            <div class="detail-row">
          
                <span class="value">{{ $application->age }}</span>
            </div>
            <div class="detail-row">
            
                <span class="value">{{ $application->civil_status }}</span>
            </div>
            <div class="detail-row">
          
                <span class="value">{{ $application->dependents }}</span>
            </div>
        </div>

        <div class="section">
       
            <div class="detail-row">
            
                <span class="value">{{ $application->employment }}</span>
            </div>
            <div class="detail-row">
            
                <span class="value">{{ $application->position }}</span>
            </div>
            <div class="detail-row">
               
                <span class="value">{{ $application->employer_name }}</span>
            </div>
            <div class="detail-row">
            
                <span class="value">{{ $application->employer_address }}</span>
            </div>
        </div>

        <div class="section">
         
            <div class="detail-row">
                
                <span class="value">{{ $application->spouse_employment }}</span>
            </div>
            <div class="detail-row">
                
                <span class="value">{{ $application->spouse_position }}</span>
            </div>
            <div class="detail-row">
               
                <span class="value">{{ $application->spouse_employer_name }}</span>
            </div>
            <div class="detail-row">
                
                <span class="value">{{ $application->spouse_employer_address }}</span>
            </div>
        </div>

        <div class="section">
        
            <div class="detail-row">
                {{ $application->properties }}
            </div>
        </div>

        <div class="section">
            <div class="section-title">Application Status</div>
            <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value">
                    <div class="status-section {{ $application->status === 'approved' ? 'status-approved' : 'status-declined' }}">
                        {{ ucfirst($application->status) }}
                    </div>
                </span>
            </div>
            @if($application->status === 'declined' && $application->decline_reason)
                <div class="detail-row">
                    <span class="label">Decline Reason:</span>
                    <span class="value">
                        <div class="decline-reason">
                            {{ $application->decline_reason }}
                        </div>
                    </span>
                </div>
            @endif
        </div>

        <div class="detail-row">
        
            <span>
                {{ $application->photo }}
            </span>
        </div>

        <div class="detail-row">
   
            <span>
                {{ $application->sketch }}
            </span>
        </div>
    </div>

    <div class="footer">
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html> 