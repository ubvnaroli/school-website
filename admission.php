<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>પ્રવેશ ફોર્મ | ઉ.બુ.ઉ.મા. શાળા, નારોલી</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', 'Nirmala UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #1a237e, #283593);
            color: white;
            padding: 25px;
            border-radius: 20px 20px 0 0;
            text-align: center;
        }
        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .header h2 {
            font-size: 1.3rem;
            color: #ffd700;
        }
        .main-content {
            background: white;
            border-radius: 0 0 20px 20px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .full-width {
            grid-column: span 2;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #1a237e;
        }
        .form-group label .required {
            color: red;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #ffd700;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255,215,0,0.2);
        }
        .stream-select {
            border-color: #4caf50 !important;
            background: #f0fff4;
        }
        .documents-section {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .documents-section h3 {
            color: #1a237e;
            margin-bottom: 15px;
        }
        .upload-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
            padding: 10px;
            background: white;
            border-radius: 8px;
        }
        .upload-btn {
            position: relative;
            background: #283593;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
        }
        .upload-btn input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        .btn-submit {
            background: linear-gradient(135deg, #1a237e, #283593);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .full-width {
                grid-column: span 1;
            }
            .upload-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏫 ઉત્તર બુનિયાદી અને ઉચ્ચતર માધ્યમિક શાળા, નારોલી</h1>
            <h2>📋 ઓનલાઈન પ્રવેશ ફોર્મ (ધોરણ 9-12) | 2026-27</h2>
        </div>
        
        <div class="main-content">
            <?php
            // સફળતાનો મેસેજ બતાવો
            if(isset($_GET['success'])) {
                echo '<div style="background: #4caf50; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold;">✅ તમારી અરજી સફળતાપૂર્વક મોકલવામાં આવી છે!</div>';
            }
            
            // એરર મેસેજ બતાવો
            if(isset($_GET['error'])) {
                echo '<div style="background: #f44336; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold;">❌ અરજી મોકલવામાં ભૂલ થઈ. ફરી પ્રયાસ કરો.</div>';
            }
            ?>
            
            <form action="process_admission.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label>વિદ્યાર્થીનું પૂરું નામ <span class="required">*</span></label>
                        <input type="text" name="student_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>જન્મ તારીખ <span class="required">*</span></label>
                        <input type="date" name="dob" required>
                    </div>
                    
                    <div class="form-group">
                        <label>ધોરણ <span class="required">*</span></label>
                        <select name="class" required>
                            <option value="">પસંદ કરો</option>
                            <option value="9">ધોરણ 9</option>
                            <option value="10">ધોરણ 10</option>
                            <option value="11">ધોરણ 11</option>
                            <option value="12">ધોરણ 12</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>સ્ટ્રીમ (ધોરણ 11-12 માટે)</label>
                        <select name="stream" class="stream-select">
                            <option value="">પસંદ કરો</option>
                            <option value="science">🔬 સાયન્સ</option>
                            <option value="commerce">📊 કોમર્સ</option>
                            <option value="arts">🎨 આર્ટ્સ</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>પિતાનું નામ <span class="required">*</span></label>
                        <input type="text" name="father_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>માતાનું નામ <span class="required">*</span></label>
                        <input type="text" name="mother_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>મોબાઇલ નંબર <span class="required">*</span></label>
                        <input type="tel" name="mobile" pattern="[0-9]{10}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>જિલ્લો</label>
                        <input type="text" name="district" value="વલસાડ">
                    </div>
                </div>
                
                <div class="full-width">
                    <div class="form-group">
                        <label>સંપૂર્ણ સરનામું <span class="required">*</span></label>
                        <textarea name="address" rows="3" required></textarea>
                    </div>
                </div>
                
                <div class="documents-section">
                    <h3>📎 દસ્તાવેજો અપલોડ કરો (JPG, PDF માત્ર, મહત્તમ 2MB)</h3>
                    
                    <div class="upload-row">
                        <label><strong>📜 એલ.સી. (તબદિલી પ્રમાણપત્ર) *</strong></label>
                        <div class="upload-btn">
                            <i class="fas fa-upload"></i> ફાઇલ પસંદ કરો
                            <input type="file" name="lc" accept=".jpg,.jpeg,.pdf" required>
                        </div>
                    </div>
                    
                    <div class="upload-row">
                        <label><strong>📊 માર્કશીટ *</strong></label>
                        <div class="upload-btn">
                            <i class="fas fa-upload"></i> ફાઇલ પસંદ કરો
                            <input type="file" name="marksheet" accept=".jpg,.jpeg,.pdf" required>
                        </div>
                    </div>
                    
                    <div class="upload-row">
                        <label><strong>🆔 આધાર કાર્ડ (વિદ્યાર્થી) *</strong></label>
                        <div class="upload-btn">
                            <i class="fas fa-upload"></i> ફાઇલ પસંદ કરો
                            <input type="file" name="aadhar" accept=".jpg,.jpeg,.pdf" required>
                        </div>
                    </div>
                    
                    <div class="upload-row">
                        <label><strong>📸 પાસપોર્ટ ફોટો *</strong></label>
                        <div class="upload-btn">
                            <i class="fas fa-upload"></i> ફાઇલ પસંદ કરો
                            <input type="file" name="photo" accept=".jpg,.jpeg" required>
                        </div>
                    </div>
                    
                    <div class="upload-row">
                        <label><strong>🏦 બેંક પાસબુક *</strong></label>
                        <div class="upload-btn">
                            <i class="fas fa-upload"></i> ફાઇલ પસંદ કરો
                            <input type="file" name="passbook" accept=".jpg,.jpeg,.pdf" required>
                        </div>
                    </div>
                    
                    <div class="upload-row">
                        <label><strong>👨 પિતાનો આધાર કાર્ડ *</strong></label>
                        <div class="upload-btn">
                            <i class="fas fa-upload"></i> ફાઇલ પસંદ કરો
                            <input type="file" name="father_aadhar" accept=".jpg,.jpeg,.pdf" required>
                        </div>
                    </div>
                    
                    <div class="upload-row">
                        <label><strong>👩 માતાનો આધાર કાર્ડ *</strong></label>
                        <div class="upload-btn">
                            <i class="fas fa-upload"></i> ફાઇલ પસંદ કરો
                            <input type="file" name="mother_aadhar" accept=".jpg,.jpeg,.pdf" required>
                        </div>
                    </div>
                    
                    <div class="upload-row">
                        <label><strong>📋 જ્ઞાતિ પ્રમાણપત્ર (વૈકલ્પિક)</strong></label>
                        <div class="upload-btn">
                            <i class="fas fa-upload"></i> ફાઇલ પસંદ કરો
                            <input type="file" name="caste" accept=".jpg,.jpeg,.pdf">
                        </div>
                    </div>
                    
                    <div class="upload-row">
                        <label><strong>🪪 રેશન કાર્ડ (વૈકલ્પિક)</strong></label>
                        <div class="upload-btn">
                            <i class="fas fa-upload"></i> ફાઇલ પસંદ કરો
                            <input type="file" name="ration" accept=".jpg,.jpeg,.pdf">
                        </div>
                    </div>
                </div>
                
                <div style="margin: 20px 0;">
                    <label style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="declaration" required>
                        <span>હું પ્રમાણિત કરું છું કે આપેલી તમામ માહિતી સાચી છે. *</span>
                    </label>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> અરજી સબમિટ કરો
                </button>
            </form>
        </div>
    </div>
</body>
</html>