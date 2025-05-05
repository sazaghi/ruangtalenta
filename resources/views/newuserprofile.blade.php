<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }
    body {
      background: #e4e7fb;
      padding: 20px;
    }
    h1 {
      margin-bottom: 20px;
      font-size: 28px;
      color: #111827;
      font-weight: 600;
    }
    .container {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    .card h3 {
      margin-bottom: 49px;
      font-size: 24px;
      color: #111827;
      font-weight: 400;
    }
    .card .sn {
      margin-bottom: 31px;
      font-size: 24px;
      color: #111827;
      font-weight: 400;
    }
    .card .ms {
      margin-bottom: 39px;
      font-size: 24px;
      color: #111827;
      font-weight: 400;
    }
    .form-group {
      margin-bottom: 31px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
      font-size: 16px;
    }
    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1.5px solid #A29D9D;
      border-radius: 8px;
      font-size: 16px;
    }
    .from-group input::placeholder {
        color: #A29D9D; /* Lebih gelap dan kontras */
    }
    .form-row {
      display: flex;
      gap: 10px;
    }
    .form-row .form-group {
      flex: 1;
    }
    .form-group .must {
        color: #F03B1E;
    }
    .avatar-upload {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 48px;
    }
    .avatar-upload div {
      width: 95px;
      height: 95px;
      background: #ccc;
    }
    .avatar-upload button {
      width: 119px;
      height: 36px;
      background-color: #4f46e5;
      color: #fff;
      border: none;
      padding: 3px 6px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      margin-left: 26px;
    }
    .save-button {
      width: 146px;
      height: 44px;
      margin-top: 40px;
      margin-bottom: 8px;
      padding: 4px 6px;
      background-color: #4056A1;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      display: flex;               /* tambahkan */
      align-items: center;         /* pusat vertikal */
      justify-content: center;     /* pusat horizontal */
      gap: 6px;                    /* jarak antara ikon dan teks */
}

    .skill-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-top: 10px;
      padding-bottom: 56px;
    }
    .tag {
      background-color: #7991FF;
      color: white;
      padding: 5px 10px;
      border-radius: 4px;
      font-size: 12px;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .tag i {
      cursor: pointer;
      font-size: 12px;
      margin-left: 4px;
      position: relative;
      top: 0.5px;
    }
    .search-skill {
      position: relative;
    }
    .search-skill input {
      width: 100%;
      padding-left: 30px;
    }
    .search-skill i {
      position: absolute;
      top: 50%;
      left: 10px;
      transform: translateY(-50%);
      color: #9ca3af;
    }
    @media (max-width: 768px) {
      .container {
        grid-template-columns: 1fr;
      }
    }

    /// Style untuk Card Education
    .card-container {
        background: #fff;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: 0 auto;
        box-sizing: border-box;
      }

      .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
      }

      .add-btn {
        background-color: #1a21d1;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        font-size: 1rem;
      }

      .education-work-entry {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        align-items: flex-start;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 1rem;
      }

      .year-badge {
        background-color:#D9D9D9;
        color: #1532B4;
        font-weight: 600;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
      }

      .education-work-details {
        flex-grow: 1;
      }

      .education-work-title {
        font-size: 20px;
        font-weight: 400;
        display: flex;
        align-items: center;
      }

      .university {
        color: #f0a500;
        font-weight: 400;
        margin: 0.2rem 0 0.4rem;
        font-size: 16px;
      }

      .work {
        color: #1532B4;
        font-weight: 400;
        margin: 0.2rem 0 0.4rem;
        font-size: 16px;
      }

      .description {
        color: #888;
        font-size: 16px;
        line-height: 1.4;
        max-width: 900px;
      }

      .delete-icon {
        cursor: pointer;
        font-size: 20px;
        color: #4a5fd3;
        margin-left: 26px;
      }

      @media (max-width: 600px) {
        .education-work-entry {
          flex-direction: column;
        }

        .education-work-title {
          flex-direction: column;
          align-items: flex-start;
          gap: 0.5rem;
        }
      }
    /// End style untuk Education

  </style>
</head>
<body>
  <h1>My Profile</h1>
  <div class="container">
    <div>
      <div class="card">
        <h3>Update your profile</h3>
        <div class="avatar-upload">
          <div></div>
          <button><i class="fas fa-upload"></i> Upload Avatar</button>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Full Name<span class="must"> *</span></label>
            <input type="text" placeholder="Enter your full name" />
          </div>
          <div class="form-group">
            <label>Email<span class="must"> *</span></label>
            <input type="email" placeholder="Enter your email" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Contact number</label>
            <input type="text" placeholder="Enter your contact number" />
          </div>
          <div class="form-group">
            <label>Personal website</label>
            <input type="text" placeholder="Enter your personal website" />
          </div>
        </div>
        <div class="form-group">
          <label>Bio</label>
          <textarea rows="3" placeholder="Enter your bio"></textarea>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Experience</label>
            <input type="text" placeholder="Enter experience" />
          </div>
          <div class="form-group">
            <label>Education Levels</label>
            <input type="text" placeholder="Enter education level" />
          </div>
        </div>
        <div class="form-group">
          <label>Languages</label>
          <input type="text" placeholder="Enter languages" />
        </div>
        <button class="save-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24">
              <path fill="currentColor" d="m8.6 22.5l-1.9-3.2l-3.6-.8l.35-3.7L1 12l2.45-2.8l-.35-3.7l3.6-.8l1.9-3.2L12 2.95l3.4-1.45l1.9 3.2l3.6.8l-.35 3.7L23 12l-2.45 2.8l.35 3.7l-3.6.8l-1.9 3.2l-3.4-1.45zm.85-2.55l2.55-1.1l2.6 1.1l1.4-2.4l2.75-.65l-.25-2.8l1.85-2.1l-1.85-2.15l.25-2.8l-2.75-.6l-1.45-2.4L12 5.15l-2.6-1.1L8 6.45l-2.75.6l.25 2.8L3.65 12l1.85 2.1l-.25 2.85l2.75.6zm1.5-4.4L16.6 9.9l-1.4-1.45l-4.25 4.25l-2.15-2.1L7.4 12z"/>
            </svg>
            Save Change
          </button>          
      </div>
    </div>
    <div>
      <div class="card">
        <h3 class="sn">Social Network</h3>
        <div class="form-group">
          <label>Facebook</label>
          <input type="text" placeholder="https://www.facebook.com" />
        </div>
        <div class="form-group">
          <label>Twitter</label>
          <input type="text" placeholder="https://twitter.com" />
        </div>
        <div class="form-group">
          <label>Instagram</label>
          <input type="text" placeholder="https://www.instagram.com" />
        </div>
        <button class="save-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24">
              <path fill="currentColor" d="m8.6 22.5l-1.9-3.2l-3.6-.8l.35-3.7L1 12l2.45-2.8l-.35-3.7l3.6-.8l1.9-3.2L12 2.95l3.4-1.45l1.9 3.2l3.6.8l-.35 3.7L23 12l-2.45 2.8l.35 3.7l-3.6.8l-1.9 3.2l-3.4-1.45zm.85-2.55l2.55-1.1l2.6 1.1l1.4-2.4l2.75-.65l-.25-2.8l1.85-2.1l-1.85-2.15l.25-2.8l-2.75-.6l-1.45-2.4L12 5.15l-2.6-1.1L8 6.45l-2.75.6l.25 2.8L3.65 12l1.85 2.1l-.25 2.85l2.75.6zm1.5-4.4L16.6 9.9l-1.4-1.45l-4.25 4.25l-2.15-2.1L7.4 12z"/>
            </svg>
            Save Change
          </button>          
      </div>

      <div class="card">
        <h3 class="ms">My Skill</h3>
        <div class="form-group search-skill">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="E.g. Angular, Laravel..." />
        </div>
        <div class="skill-tags">
          <span class="tag">Laravel <i class="fas fa-times">X</i></span>
          <span class="tag">Figma <i class="fas fa-times">X</i></span>
          <span class="tag">React <i class="fas fa-times">X</i></span>
          <span class="tag">Photoshop <i class="fas fa-times">X</i></span>
          <span class="tag">Laravel <i class="fas fa-times">X</i></span>
          <span class="tag">Figma <i class="fas fa-times">X</i></span>
          <span class="tag">React <i class="fas fa-times">X</i></span>
        </div>
        <button class="save-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24">
              <path fill="currentColor" d="m8.6 22.5l-1.9-3.2l-3.6-.8l.35-3.7L1 12l2.45-2.8l-.35-3.7l3.6-.8l1.9-3.2L12 2.95l3.4-1.45l1.9 3.2l3.6.8l-.35 3.7L23 12l-2.45 2.8l.35 3.7l-3.6.8l-1.9 3.2l-3.4-1.45zm.85-2.55l2.55-1.1l2.6 1.1l1.4-2.4l2.75-.65l-.25-2.8l1.85-2.1l-1.85-2.15l.25-2.8l-2.75-.6l-1.45-2.4L12 5.15l-2.6-1.1L8 6.45l-2.75.6l.25 2.8L3.65 12l1.85 2.1l-.25 2.85l2.75.6zm1.5-4.4L16.6 9.9l-1.4-1.45l-4.25 4.25l-2.15-2.1L7.4 12z"/>
            </svg>
            Save Change
          </button>          
      </div>
    </div>
  </div>
  <div class="card">
    <h3>Contact Information</h3>
    <div class="form-row">
      <div class="form-group">
        <label>Country</label>
        <input type="text" placeholder="Enter your country" />
      </div>
      <div class="form-group">
        <label>City</label>
        <input type="text" placeholder="Enter your city" />
      </div>
    </div>
    <div class="form-group">
      <label>Complete Address</label>
      <input type="text" placeholder="Enter your complete address" />
    </div>
    <button class="save-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24">
          <path fill="currentColor" d="m8.6 22.5l-1.9-3.2l-3.6-.8l.35-3.7L1 12l2.45-2.8l-.35-3.7l3.6-.8l1.9-3.2L12 2.95l3.4-1.45l1.9 3.2l3.6.8l-.35 3.7L23 12l-2.45 2.8l.35 3.7l-3.6.8l-1.9 3.2l-3.4-1.45zm.85-2.55l2.55-1.1l2.6 1.1l1.4-2.4l2.75-.65l-.25-2.8l1.85-2.1l-1.85-2.15l.25-2.8l-2.75-.6l-1.45-2.4L12 5.15l-2.6-1.1L8 6.45l-2.75.6l.25 2.8L3.65 12l1.85 2.1l-.25 2.85l2.75.6zm1.5-4.4L16.6 9.9l-1.4-1.45l-4.25 4.25l-2.15-2.1L7.4 12z"/>
        </svg>
        Save Change
    </button>          
  </div>
  <div class="card">
    <div class="card-container">
      <div class="card-header">
        <h3>Education</h3>
        <button class="add-btn">+ Add Education</button>
      </div>
      <div id="education-work-list">
        <div class="education-work-entry">
          <div class="year-badge">2012-2014</div>
            <div class="education-work-details">
              <div class="education-work-title">
                <span>Computer Science</span>
                <span class="delete-icon" onclick="this.closest('.education-work-entry').remove()">🗑</span>
              </div>
            <div class="university">Oxford University</div>
            <div class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sem id enim suscipit commodo nec in ante. Sed viverra vel leo vitae pharetra. Morbi viverra venenatis neque, eu porttitor diam blandit.</div>
          </div>
        </div>
        <div class="education-work-entry">
          <div class="year-badge">2012-2014</div>
            <div class="education-work-details">
              <div class="education-work-title">
                <span>Computer Science</span>
                <span class="delete-icon" onclick="this.closest('.education-work-entry').remove()">🗑</span>
              </div>
            <div class="university">Oxford University</div>
            <div class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sem id enim suscipit commodo nec in ante. Sed viverra vel leo vitae pharetra. Morbi viverra venenatis neque, eu porttitor diam blandit.</div>
          </div>
        </div>
        <div class="education-work-entry">
          <div class="year-badge">2012-2014</div>
            <div class="education-work-details">
              <div class="education-work-title">
                <span>Computer Science</span>
                <span class="delete-icon" onclick="this.closest('.education-work-entry').remove()">🗑</span>
              </div>
            <div class="university">Oxford University</div>
            <div class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sem id enim suscipit commodo nec in ante. Sed viverra vel leo vitae pharetra. Morbi viverra venenatis neque, eu porttitor diam blandit.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-container">
      <div class="card-header">
        <h3>Work & Experience</h3>
        <button class="add-btn">+ Add Work</button>
      </div>
      <div id="education-work-list">
        <div class="education-work-entry">
          <div class="year-badge">2012-2014</div>
            <div class="education-work-details">
              <div class="education-work-title">
                <span>Product Designer</span>
                <span class="delete-icon" onclick="this.closest('.education-work-entry').remove()">🗑</span>
              </div>
            <div class="work">Spotify Inc.</div>
            <div class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sem id enim suscipit commodo nec in ante. Sed viverra vel leo vitae pharetra. Morbi viverra venenatis neque, eu porttitor diam blandit.</div>
          </div>
        </div>
        <div class="education-work-entry">
          <div class="year-badge">2012-2014</div>
            <div class="education-work-details">
              <div class="education-work-title">
                <span>Product Designer</span>
                <span class="delete-icon" onclick="this.closest('.education-work-entry').remove()">🗑</span>
              </div>
            <div class="work">Spotify Inc.</div>
            <div class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sem id enim suscipit commodo nec in ante. Sed viverra vel leo vitae pharetra. Morbi viverra venenatis neque, eu porttitor diam blandit.</div>
          </div>
        </div>
        <div class="education-work-entry">
          <div class="year-badge">2012-2014</div>
            <div class="education-work-details">
              <div class="education-work-title">
                <span>Product Designer</span>
                <span class="delete-icon" onclick="this.closest('.education-work-entry').remove()">🗑</span>
              </div>
            <div class="work">Spotify Inc.</div>
            <div class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sem id enim suscipit commodo nec in ante. Sed viverra vel leo vitae pharetra. Morbi viverra venenatis neque, eu porttitor diam blandit.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>