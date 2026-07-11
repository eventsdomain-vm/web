Project email: eventsdomain.com@gmail.com
Phone No: +91 9725098250
https://www.figma.com/colors/terracotta/

https://tailadmin.com/

http://localhost:3847/




 Credentials created:
- Organizer: organizer@eventsdomain.com / password123
- Admin: admin@eventsdomain.com / password123 (password reset)


CLI: freebuff


Continuing Phase 1. Let me update the SponsorshipPackage model to point at the  renamed sponsor_packages table (keeping the class name so existing
  controllers work), then fix the two validation strings.

● Update(app\Models\SponsorshipPackage.php)
  ⎿  Added 12 lines
      13  {
      14      use HasFactory;
      15  
      16 +    /**                                                        
      17 +     * The domain redesign renamed this table to `sponsor_packa
         +ges` (the spec's                                               
      18 +     * "Sponsor Packages"). The class name is retained so exist
         +ing controllers                                                
      19 +     * and views keep working unchanged.                       
      20 +     */                                                        
      21 +    protected $table = 'sponsor_packages';                     
      22 +                                                               
      23      protected $fillable = [
      24          'event_id',
      25          'title',
      26 +        'level',                                               
      27          'description',
      28          'price',
      29 +        'currency',                                            
      30 +        'budget_range_label',                                  
      31          'slots_available',
      32          'slots_filled',
      33 +        'benefits',                                            
      34          'is_active',
      35          'sort_order',
      36      ];
     ...
      39          'price' => 'decimal:2',
      40          'slots_available' => 'integer',
      41          'slots_filled' => 'integer',
      42 +        'benefits' => 'array',                                 
      43          'is_active' => 'boolean',
      44          'sort_order' => 'integer',
      45      ];

 7 tasks (0 done, 1 in progress, 6 open)
  ◼ Phase 1: Database foundation (migrations, models, observers)
  ◻ Phase 2: Import pipeline from sponsorshipsearch_data.json
  ◻ Phase 3: Participants + dynamic category forms  ◻ Phase 4: Service / Repository / Policy layer
  ◻ Phase 5: Organizer 10-step wizard rebuild   … +2 pending