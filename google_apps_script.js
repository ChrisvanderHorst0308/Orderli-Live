/**
 * Google Apps Script voor automatisch toevoegen van rijen aan Google Sheets
 * 
 * INSTRUCTIES:
 * 1. Open je Google Sheet: https://docs.google.com/spreadsheets/d/1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k/edit
 * 2. Ga naar Extensies → Apps Script
 * 3. Plak deze code
 * 4. Klik op "Deploy" → "New deployment"
 * 5. Kies "Web app"
 * 6. Execute as: Me
 * 7. Who has access: Anyone
 * 8. Klik "Deploy"
 * 9. Kopieer de Web App URL
 * 10. Voeg de URL toe aan admin_dashboard.php (regel ~20, variabele $webhookUrl)
 */

// Vervang dit met je Sheet ID
const SHEET_ID = '1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k';
const SHEET_NAME = 'Sheet1'; // Of de naam van je tabblad

function doPost(e) {
  try {
    // Parse incoming JSON data
    const data = JSON.parse(e.postData.contents);
    const rowData = data.row;
    
    // Open the spreadsheet
    const ss = SpreadsheetApp.openById(SHEET_ID);
    const sheet = ss.getSheetByName(SHEET_NAME) || ss.getActiveSheet();
    
    // Append the new row (starts from row 2, skipping header)
    sheet.appendRow(rowData);
    
    // Return success response
    return ContentService
      .createTextOutput(JSON.stringify({
        success: true,
        message: 'Row added successfully',
        row: rowData.length
      }))
      .setMimeType(ContentService.MimeType.JSON);
      
  } catch (error) {
    // Return error response
    return ContentService
      .createTextOutput(JSON.stringify({
        success: false,
        error: error.toString()
      }))
      .setMimeType(ContentService.MimeType.JSON);
  }
}

function doGet(e) {
  // Test endpoint
  return ContentService
    .createTextOutput('Google Apps Script Webhook is active!')
    .setMimeType(ContentService.MimeType.TEXT);
}
