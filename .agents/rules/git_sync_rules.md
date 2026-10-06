# Git Senkronizasyon ve İşbirliği Kuralları (Git Sync Rules)

Bu kural, projede birden fazla kişi çalıştığı için Antigravity tarafından **otomatik olarak** uygulanmalıdır:

1. **İşe Başlamadan Önce Kontrol (Pre-Work Sync):**
   - Projede git remote bağlı ise, yeni bir kodlama veya düzenleme görevine başlamadan önce mutlaka uzaktaki değişiklikleri kontrol et (`git pull`).
   - Karşı tarafın yaptığı son değişiklikler varsa ezilmeden yerel ortama dahil edilmelidir.

2. **İş Bitiminde Senkronizasyon (Post-Work Sync):**
   - Yapılan her anlamlı değişiklik veya hata düzeltmesi sonrasında kodlar temiz, açıklayıcı bir commit mesajı ile commit edilmeli ve uzaktaki depoya (`git push`) gönderilmelidir.

3. **Çakışma Yönetimi (Conflict Prevention & Resolution):**
   - Bir çakışma (*merge conflict*) oluştuğunda, karşı tarafın yazdığı kodlar silinmemeli; bizim yazdığımız kodlarla akıllıca birleştirilmelidir.
