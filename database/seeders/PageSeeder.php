<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $aboutBody = <<<'HTML'
<p><strong>Welcome to the home of 1000 Hills Rugby!</strong> Here, we share our story, our mission, and the milestones that define our journey of transforming lives through rugby.</p>

<h2>Our Roots</h2>
<p>1000 Hills Rugby was born in 2014 at Don Bosco Gatenga with a bold vision: to harness the power of rugby as a unifying force. Our aim was to create a safe and enjoyable environment where young athletes could grow their skills, deepen their understanding of the game, and play rugby to their fullest potential. Recognizing the challenges faced by Rwanda’s youth, we combined sports with education to tackle employability and ensure sustainable livelihoods.</p>
<p>Starting with just three Level 1 coaches and 20 U18 boys, we quickly expanded through the World Rugby’s "Get Into Rugby" program. By early 2016, we had grown into a thriving community of 25 senior members, 20 U18 women, and 20 U16 boys. Currently, we have over 150 beneficiaries in our programs.</p>

<h2>Our Mission</h2>
<p>To nurture our players into becoming the best men’s, women’s, and youth teams in Rwanda. We aim to be the foundation of excellence, fostering winning teams and providing a supportive, inclusive sporting community for individuals of all ages and genders. Through rugby, we empower players with education and employability skills, preparing them for a brighter future both on and off the field.</p>

<h2>Our Vision</h2>
<p>To establish 1000 Hills Rugby as the heart of rugby in Rwanda. We envision preparing players to compete internationally, representing Rwanda with pride, while equipping them with the tools to thrive academically and professionally. By integrating education and employability into our programs, we aim to develop disciplined, active contributors to society and the economy.</p>

<h2>Our Core Values</h2>
<ol>
    <li><strong>Discipline:</strong> Staying committed to growth, learning, and personal accountability.</li>
    <li><strong>Sportsmanship:</strong> Promoting respect, fairness, and camaraderie on and off the field.</li>
    <li><strong>Mutuality:</strong> Building a community of shared goals, respect, and support for all members.</li>
    <li><strong>Integrity:</strong> Upholding honesty and transparency in all our actions.</li>
    <li><strong>Strength:</strong> Cultivating both mental and physical resilience to face challenges head-on.</li>
    <li><strong>Empowerment:</strong> Providing opportunities for education and employability to build well-rounded, self-reliant individuals.</li>
</ol>

<h2>Milestones Achieved</h2>
<ul>
    <li>In 2016, we proudly contributed five players to Rwanda Rugby’s National Team for the African Rugby Cup Division 2 South.</li>
    <li>We won the Rwanda Rugby National League in 2016.</li>
    <li>Champions of the Kigali 7s Tournament in 2017 and 2018.</li>
    <li>Winners of the Genocide Memorial Tournament in 2016, 2017, and 2018.</li>
    <li>Hosted the Rugby 7s tournament from 2016 to 2018 to strengthen regional competition.</li>
    <li>The first two editions were won by Remera Buffaloes, while 1000 Hills Rugby claimed victory in the third edition.</li>
</ul>
<p>While challenges delayed subsequent events, we are thrilled to announce the return of this prestigious tournament in December 2025.</p>

<h2>Community Impact</h2>
<p>At 1000 Hills Rugby, our influence extends far beyond the pitch. Through our annual charity event, 1000 Hills Rugby Voice, we promote healthy lifestyles and community development.</p>
<p>During the COVID-19 pandemic, we mobilized our global supporters to sustain our programs, ensuring our mission endured.</p>
<p>In 2023-2024, we launched the initiative "Building Stronger Bonds: Uniting Families through Rugby for Future Leaders." This program strengthens player-family relationships, fostering deeper connections and support.</p>
<p>Visiting 26 families of U18 boys and girls in Kicukiro District, we have seen higher attendance, stronger parental involvement, and a brighter future for our young athletes.</p>

<h2>The Road Ahead</h2>
<p>Looking ahead, our focus remains on empowering Rwanda’s youth through sports, education, and employability programs. By leveraging rugby as a tool for positive change, we aim to tackle the challenges faced by young people and create a sustainable future for our community.</p>

<h2>Join Us</h2>
<p>As we embark on this exciting chapter, we invite you to be part of the 1000 Hills Rugby journey. Together, we can continue to inspire, empower, and transform lives through the spirit of rugby.</p>
HTML;

        $communityBody = <<<'HTML'
<p>Join the 1000 Hills Rugby community of rugby enthusiasts, athletes, and learners. Build your skills, collaborate on initiatives, and create lasting connections that promote personal and professional growth through our programs.</p>

<h2>Our Community</h2>
<p>Discover the heart of 1000 Hills Rugby—where youth, families, and partners grow through sport, learning, and connection.</p>

<h3>Belonging &amp; Support</h3>
<p>We offer a safe space where players, parents, and supporters feel accepted, and part of something bigger.</p>

<h3>Rugby Skills &amp; Teamwork</h3>
<p>Join our training sessions to grow your rugby skills, build discipline, and learn the power of teamwork.</p>

<h3>Family &amp; Community Time</h3>
<p>Come together through our fun and meaningful events that celebrate unity, culture, and the love of rugby.</p>

<h3>Learning Life Skills</h3>
<p>Take part in workshops that build confidence, communication, job readiness, and other important life skills.</p>

<h3>Inspiring the Next Generation</h3>
<p>Through outreach in schools and communities, we help more young people learn, play, and dream big through rugby.</p>

<h3>Stay &amp; Compete</h3>
<p>Show your talent and spirit on the field in tournaments that bring teams, families, and communities together.</p>

<h3>Stay Active &amp; Healthy</h3>
<p>Enjoy health and fitness activities that support the well-being of our players and encourage healthy habits for life.</p>

<h3>Connect with the World</h3>
<p>Grow your network by engaging with rugby friends and supporters from Rwanda and beyond.</p>

<h2>Leaders of the Game</h2>
<p><strong>Experience, Leadership, and Legacy</strong></p>
<p>At 1000 Hills Rugby, we take pride in our experienced members who bring years of leadership, wisdom, and dedication to the field. Our team members, both on and off the field, are not just athletes but also mentors, role models, and key figures in our community. Their commitment to the game and fostering a positive environment creates a lasting impact, inspiring the next generation. Watch their stories and see how they continue to shape the future of rugby and our community.</p>

<h2>Empowering Girls through Rugby</h2>
<p><strong>Strength, Courage, and Support!</strong></p>
<p>At 1000 Hills Rugby, we are dedicated to celebrating and empowering girls through the transformative power of sport. Our girls' program goes beyond athletic development; it fosters confidence, teamwork, and community involvement, creating a holistic environment where young women can thrive. We believe that by participating in rugby, girls can break barriers, challenge stereotypes, and develop the leadership skills necessary to excel both on and off the field. Our program is designed to inspire and support female athletes, encouraging them to embrace their strength and determination while forging lasting friendships within a supportive community.</p>
<p>We invite you to join us in championing our female athletes as they showcase their skills and resilience. Through rigorous training, mentorship, and competitive opportunities, we equip young women with the tools they need to succeed in rugby and life. At 1000 Hills Rugby, we are committed to nurturing the next generation of female leaders, empowering them to make a positive impact in their communities and beyond. Together, let’s celebrate the strength, courage, and spirit of our girls as they rise to new heights in the world of rugby!</p>

<h2>Inspiring and Uplifting Our Youth</h2>
<p><strong>Building Future Leaders!</strong></p>
<p>At 1000 Hills Rugby, we are committed to empowering young people through sport and beyond. We focus on cultivating leadership, teamwork, and resilience in every young athlete. Each training session, event, and activity is an opportunity to build character and instill lifelong values. Together, we are shaping the next generation of leaders who will carry forward the spirit and strength of our community, both on and off the field.</p>

<h2>Register Now</h2>
<p>Don’t miss out on this incredible opportunity! This is your chance to gain valuable skills, connect with rugby experts, and collaborate with like-minded individuals. Join us for a transformative experience and be part of something special—an experience of a lifetime.</p>
HTML;

        $educationBody = <<<'HTML'
<h2>Introduction</h2>
<p>The 1000 Hills Rugby Education Program is dedicated to empowering young girls and boys by providing them with educational opportunities that can transform their lives. This initiative emerged from our engagement with young rugby players, many of whom come from underserved backgrounds.</p>
<p>We recognize the financial hardships they face, which can hinder their ability to continue their education. Through this program, we seek to eliminate these barriers and ensure that every child has the opportunity to pursue an education and a brighter future.</p>

<h2>Vision</h2>
<p>Our vision is to create a society where every child, irrespective of gender or financial circumstances, has equal access to quality education. We believe education is not just a fundamental right but also a transformative force that drives personal growth, empowerment, and sustainable societal progress.</p>

<h2>Mission</h2>
<p>Our mission is to mobilize support from friends, families, and organizations committed to investing in the education of young rugby players. By highlighting the challenges these children face, we aim to inspire collective action and create sustainable opportunities for them to access quality education.</p>

<h2>Purpose</h2>
<p>The purpose of the 1000 Hills Rugby Education Program is to eliminate financial obstacles that hinder children's access to education. Many families face significant economic hardships, making it difficult to afford school fees and essential learning materials. Our program seeks to provide financial aid, educational resources, and mentorship to ensure these children not only stay in school but also thrive academically and personally.</p>

<h2>Approach</h2>
<p>We take a holistic approach to education, recognizing that it involves more than just financial assistance. While we aim to cover school fees, we also prioritize mentorship, life skills development, and emotional support. We encourage sponsors to form meaningful connections with the children they support, serving as mentors and role models. Additionally, we offer opportunities for sponsors to engage in video calls and interactive sessions, fostering a nurturing and empowering community.</p>

<h2>How to Support</h2>
<p>If you are willing to make a difference in the lives of these children, we invite you to join our cause. Your contributions, no matter how small, can have a profound impact. For example, a donation of $50 can help one player receive a school bag and essential stationery for a year, ensuring they have the necessary materials to support their education. We provide sponsors with the child’s details, family contact information, and the school's bank account details for direct transfers. Together, we can give these children the educational opportunities they deserve.</p>

<h2>The Role of Rugby</h2>
<p>As part of our program, supported children will have the opportunity to engage in rugby, which is at the core of 1000 Hills Rugby’s mission. While participation is encouraged but not mandatory, we recognize the transformative power of rugby. The sport fosters discipline, teamwork, resilience, and leadership—skills that benefit young players both on and off the field. By integrating rugby into our education program, we not only enhance their physical well-being but also instill confidence and a sense of belonging in a structured, supportive environment.</p>

<h2>Our Achievements</h2>
<p>Over the years, the 1000 Hills Rugby Education Program has grown significantly. We began by supporting just 10 players, and through continued effort and community support, we have expanded our impact to 65 beneficiaries under the SESLA program. This achievement demonstrates our dedication to providing educational opportunities for young athletes.</p>

<h3>Education Support Breakdown</h3>
<ul>
    <li>Total Registered Members: 123</li>
    <li>Total Beneficiaries under SESLA: 65</li>
    <li>Girls Supported: 35</li>
    <li>Boys Supported: 30</li>
</ul>

<h2>Testimony from a Beneficiary</h2>
<blockquote>
    <p>“Before joining the 1000 Hills Rugby Education Program, I struggled to continue my Advanced Level studies due to financial constraints. Joining 1000 Hills Rugby gave me an opportunity to be part of this program, which helped me continue my education.</p>
    <p>Thanks to this initiative, I have been able to go back to school, receive school supplies, and develop my rugby skills. The support I have received has given me hope for a better future, both academically and in sports.”</p>
    <p><strong>— IRADUKUNDA IGIHOZO KEVINE, 18 Years, G.S. GATENGA</strong></p>
</blockquote>

<h2>Conclusion</h2>
<p>The 1000 Hills Rugby Education Program is committed to breaking the cycle of limited opportunities for children from underserved communities. We believe that education is a powerful tool that can unlock potential, uplift communities, and create lasting change. By providing financial assistance, fostering personal connections, and promoting rugby participation, we aim to empower these children to become future leaders and role models.</p>
<p>Together, let's support their education, transform lives, and build a more equitable society.</p>
HTML;

        $foundationBody = <<<'HTML'
<p>At 1000 Hills Rugby, we use rugby as a tool to unlock potential and prepare youth for successful futures. Our Career Guidance Program empowers boys and girls with life skills, job readiness, and entrepreneurship training in a safe, inclusive environment.</p>
<p>Through hands-on workshops and expert-led sessions, participants build confidence, set goals, and develop leadership, teamwork, communication, CV writing, interview, and critical thinking skills. We help youth discover their passions, whether in sports, business, or other careers, and prepare them to thrive.</p>

<h2>Our Skills Development</h2>
<p>We follow a structured approach to equip youth with essential skills for life and work.</p>

<h3>Confidence Building</h3>
<p>Developing self-assurance through achievement, positive reinforcement, and overcoming challenges on and off the field.</p>

<h3>Goal Setting</h3>
<p>Learning to set SMART goals and develop strategies to achieve personal, academic, and professional objectives.</p>

<h3>Leadership</h3>
<p>Cultivating the ability to guide, inspire and motivate others through rugby team roles and community projects.</p>

<h3>Teamwork</h3>
<p>Mastering collaboration, conflict resolution and collective achievement through rugby and group initiatives.</p>

<h3>Communication</h3>
<p>Developing effective verbal, non-verbal and digital communication skills for professional environments.</p>

<h3>CV Writing</h3>
<p>Creating professional resumes, cover letters and online profiles that effectively showcase skills and experience.</p>

<h3>Interview Skills</h3>
<p>Mastering the art of professional interviews, from preparation to follow-up, through mock sessions and feedback.</p>

<h3>Critical Thinking</h3>
<p>Developing analytical abilities, problem-solving techniques and decision-making skills for real-world challenges.</p>

<h3>Continuous Growth</h3>
<p>Applying all learned skills in real-world scenarios while developing habits for lifelong learning and adaptation.</p>

<h2>Join Our Movement</h2>
<p>Together, we're building a generation of resilient, skilled leaders ready to transform their communities. Partner with us to shape the future.</p>
HTML;

        $academyBody = <<<'HTML'
<h2>Player Development Program</h2>
<p>At 1000 Hills Rugby, we believe in nurturing talent both on and off the field, and our Player Development Program is at the heart of this mission. This program is designed to help players grow their skills, build confidence, and reach their full potential. From technical rugby training to personal development sessions, we ensure our players are prepared for success in the game and beyond. It’s more than just rugby—it’s about empowering individuals with the tools they need to excel in life. Together, we are building a strong foundation for future champions.</p>
<p><strong>Age Group:</strong> 18+ years</p>
<ul>
    <li>Enhancing technical and tactical rugby skills</li>
    <li>Building strength, endurance, and agility</li>
    <li>Offering workshops on leadership, teamwork, communication, and life skills</li>
    <li>Preparing players for opportunities within and outside of rugby</li>
</ul>

<h2>Women’s Rugby Program</h2>
<p><strong>Empowering Women Through Rugby</strong></p>
<p>At 1000 Hills Rugby, we believe in the transformative power of sports to inspire, uplift, and empower women. Our Women’s Rugby Program is thoughtfully designed to create opportunities for females aged 12 and above to thrive both on and off the field.</p>

<h3>Who Can Join?</h3>
<p><strong>Age Group:</strong> 12+ years.</p>
<p>Open to beginners and experienced players alike, our program welcomes all women looking to enhance their rugby skills and personal development.</p>

<h3>What We Offer</h3>
<p><strong>Regular Training and Fitness Programs</strong></p>
<p><strong>Train Like a Champion:</strong> Participate in weekly sessions focused on sharpening rugby skills and boosting overall fitness, setting players up for success on the field.</p>
<p><strong>Customized for Excellence:</strong> Tailored training plans ensure that every player, from beginner to advanced, achieves their full potential.</p>
<p><strong>Education and Employability Opportunities</strong></p>
<p><strong>Learn, Grow, Succeed:</strong> Engage in workshops that build essential skills for academic achievement and career advancement.</p>
<p><strong>Your Future, Empowered:</strong> Access mentorship and career guidance that opens doors to limitless opportunities.</p>
<p><strong>Supporting Education:</strong> We facilitate school fees and provide necessary materials such as books, bags, and other essentials to ensure our players can excel both in the classroom and on the field.</p>
<p><strong>Competitive Play</strong></p>
<p><strong>Compete, Win, Inspire:</strong> Take part in thrilling local and regional tournaments, building teamwork and a winning mindset.</p>
<p><strong>On the World Stage:</strong> Represent the club and Rwanda with pride, showcasing your talent on national and international platforms.</p>
<p><strong>Leadership and Personal Development</strong></p>
<p><strong>Leaders On and Off the Field:</strong> Develop leadership skills that inspire teammates and create positive change beyond rugby.</p>
<p><strong>Confidence Unlocked:</strong> Participate in workshops that strengthen resilience and prepare you to tackle life’s challenges.</p>
<p><strong>Mentorship</strong></p>
<p><strong>Guidance for Greatness:</strong> Learn from experienced players and coaches who provide invaluable support for both personal and athletic growth.</p>
<p><strong>Inspiring the Next Generation:</strong> Receive mentorship that shapes you into a role model for future players.</p>
<p>Whether you’re looking to play competitively, improve your fitness, or simply be part of a supportive community, the Women’s Rugby Program is your platform to grow, learn, and shine. Join us in empowering women through rugby!</p>

<h2>Rugby &amp; Life Skills Program</h2>
<p><strong>Empowering Future Leaders Through Rugby</strong></p>
<p>At 1000 Hills Rugby, we understand that rugby is more than just a game; it is a powerful tool for personal and community development. Our Rugby &amp; Life Skills Program is specifically designed for players aged 10 and above, combining high-quality rugby training with essential life skills education. This holistic approach ensures that our participants not only excel in their athletic pursuits but also grow into well-rounded individuals ready to face the challenges of life.</p>

<h3>Program Highlights</h3>
<p><strong>Inclusive Participation</strong><br>Open to boys and girls of all skill levels, our program welcomes everyone from senior teams to development squads and juniors, fostering a supportive and inclusive environment.</p>
<p><strong>Comprehensive Workshops</strong><br>Participants engage in workshops focused on leadership, communication, and teamwork, where they learn to lead with integrity and collaborate effectively with others.</p>
<p><strong>Practical Life Skills</strong><br>Our curriculum includes sessions on financial literacy, health, and career development, equipping players with the knowledge and skills necessary for making informed life choices and achieving their professional aspirations.</p>
<p><strong>Mentorship Opportunities</strong><br>Players benefit from mentorship by senior players and community leaders, gaining valuable insights and guidance that inspire personal and professional growth.</p>
<p><strong>Character Development</strong><br>We emphasize the importance of discipline, integrity, and resilience, helping players navigate challenges both on and off the field while preparing them to be active contributors to society.</p>

<h3>Why Choose Our Program?</h3>
<p>The Rugby &amp; Life Skills Program at 1000 Hills Rugby is committed to nurturing disciplined, empowered individuals who embody the values of sportsmanship, mutual respect, and community engagement. By integrating athletic training with life skills education, we prepare our players to become leaders and role models, ready to represent Rwanda with pride on the international stage.</p>
<p>Join us in building champions on and off the field!</p>

<h2>Grassroots Rugby Initiative</h2>
<p><strong>Bringing Rugby to Every Corner of Rwanda</strong></p>
<p>At 1000 Hills Rugby, we believe that every child deserves the opportunity to discover the joy of rugby and the invaluable life skills it imparts. Our Grassroots Rugby Initiative is dedicated to introducing the sport to underserved communities, breaking down barriers, and nurturing future talent. This program aligns with our mission to foster inclusivity, develop youth, and empower communities through the transformative power of rugby.</p>

<h3>Who Can Join?</h3>
<p><strong>Age Group:</strong> 6–15 years</p>
<p>Open to boys and girls in schools and communities with limited access to sports programs, our initiative welcomes all young aspiring athletes.</p>

<h3>What We Offer</h3>
<p><strong>Rugby Introduction Clinics in Schools and Communities</strong></p>
<p><strong>Engaging Learning Experiences:</strong> Age-appropriate training delivered by experienced coaches to ensure a positive introduction to the sport.</p>
<p><strong>Free Access to Equipment and Training</strong></p>
<p><strong>Essential Gear Provided:</strong> We supply rugby balls, kits, and other necessary equipment to ensure that all participants can engage fully in the program.</p>
<p><strong>Inclusive Training Environment:</strong> Our sessions prioritize safety, teamwork, and sportsmanship, creating a welcoming atmosphere for all.</p>
<p><strong>Collaboration with Local Schools to Promote Rugby Education</strong></p>
<p><strong>Partnerships for Progress:</strong> We work closely with schools to integrate rugby into their physical education programs, enhancing the overall sports curriculum.</p>
<p><strong>Teacher Workshops:</strong> Hosting workshops for educators to equip them with the tools and knowledge to support long-term rugby education in their schools.</p>
<p><strong>Facilitating Education Support</strong></p>
<p><strong>Comprehensive Assistance:</strong> We provide school fees and essential materials such as books, bags, and uniforms to ensure that all participants can thrive both academically and athletically.</p>
<p><strong>Holistic Development:</strong> Our goal is to ensure that young players have the resources they need to succeed in all aspects of their lives.</p>
<p><strong>Talent Scouting for the Youth Development Program</strong></p>
<p><strong>Identifying Future Stars:</strong> We actively scout and nurture young talent, providing pathways for skilled players to advance into our Youth Development Program for continued growth and competitive play.</p>

<h3>Why Join?</h3>
<p>The Grassroots Rugby Initiative aims to inspire the next generation of players by instilling core values of discipline, mutual respect, and teamwork. By making rugby accessible to all, we empower young people to become confident, active members of their communities, ready to embrace the challenges of life both on and off the field.</p>
HTML;

        $privacyBody = <<<'HTML'
<h2>Introduction</h2>
<p>1000 Hills Rugby values your privacy and complies with Rwanda's privacy laws. This policy explains how we collect, use, and protect your personal information when you visit our website (https://1000hillsrugby.rw), engage with our services, or interact with us.</p>

<h2>Your Rights</h2>
<p>We use your personal information only for the purposes stated in this policy. If you disagree with this policy, you should stop using our services and website.</p>

<h2>Information We Collect</h2>
<p>We may collect the following personal information:</p>
<ul>
    <li>Your name, contact details, and any information you provide directly (e.g., during registrations or inquiries).</li>
    <li>Information about your use of our website, such as pages visited and time spent.</li>
    <li>Data from surveys or feedback.</li>
</ul>
<p>Please do not provide information about others unless they consent to this and are aware of this policy.</p>

<h2>How We Collect Your Information</h2>
<p>We collect personal information:</p>
<ul>
    <li>Directly from you (e.g., when you fill out forms).</li>
    <li>Indirectly through your website use or social media interactions.</li>
    <li>From third parties, such as analytics services.</li>
</ul>

<h2>How We Use and Share Your Information</h2>
<p>Your information is used for the following purposes:</p>
<ul>
    <li>To provide services, process donations, or manage registrations.</li>
    <li>To improve our website functionality and user experience.</li>
    <li>To respond to your inquiries or feedback.</li>
    <li>To comply with legal obligations.</li>
</ul>
<p>We will not sell or rent your personal data. Information may be shared with service providers only for operational purposes.</p>

<h2>Cookies</h2>
<p>We use cookies to enhance your browsing experience. You can adjust your browser settings to disable cookies, though this may impact some features on the site.</p>

<h2>Third-Party Links</h2>
<p>Our website may include links to third-party sites. These sites operate independently and have their own privacy policies, for which we are not responsible.</p>

<h2>Your Rights to Access and Correction</h2>
<p>You have the right to access and correct your personal information. If you believe your data is incorrect, you may contact us at info@1000hillsrugby.rw.</p>

<h2>Changes to This Privacy Policy</h2>
<p>This policy may be updated periodically. Any changes will be posted on our website and will take effect 14 days after posting. Continued use of our website or services implies acceptance of the updated terms.</p>

<h2>Contact Us</h2>
<p>For privacy-related inquiries, please email info@1000hillsrugby.rw.</p>
HTML;

        $pages = [
            [
                'title' => 'The Journey of 1000 Hills Rugby: Empowering Communities Through Sport',
                'slug' => 'about',
                'subtitle' => 'Welcome to the home of 1000 Hills Rugby! Here, we share our story, our mission, and the milestones that define our journey of transforming lives through rugby.',
                'hero_image' => 'images/26.JPG',
                'excerpt' => '1000 Hills Rugby was born in 2014 at Don Bosco Gatenga with a bold vision: to harness the power of rugby as a unifying force.',
                'body' => $aboutBody,
                'sections' => [
                    [
                        'title' => 'Celebrating Achievements',
                        'content' => '<p><strong>Honoring Excellence on and off the Field</strong></p><p>At 1000 Hills Rugby Team, we believe that every achievement, no matter how small, deserves recognition and celebration. Our commitment to excellence is reflected in our passion for honoring the milestones of our players, from triumphant victories in local tournaments to personal accomplishments that shape their journeys.</p><p>Each success is a testament to hard work, perseverance, and dedication, showcasing not only athletic abilities but also the core values of resilience, sportsmanship, and camaraderie that define our club. We understand that the journey of a rugby player extends beyond the game, encompassing personal growth, character development, and the forging of lifelong friendships. Our celebrations extend beyond athletic achievements to include personal milestones in academics, community service, and leadership. By acknowledging these successes, we foster a culture of encouragement and support that inspires our players to strive for greatness in all aspects of their lives. At 1000 Hills Rugby, we invite everyone to join us in honoring the spirit of excellence that permeates our team. Together, we celebrate the dedication and passion of our players, coaches, and supporters, creating a vibrant community that motivates individuals to reach their full potential and build a legacy of achievement for future generations.</p>',
                    ],
                    [
                        'title' => 'Rising with 1000 Hills Rugby: Real-world Impact',
                        'content' => '<p>At 1000 Hills Rugby, we are fueled by a steadfast spirit of resilience and progress, dedicated to equipping individuals with the essential tools to tackle real-world challenges. Our comprehensive program empowers participants through hands-on projects and collaborative initiatives that reflect the complexities of today’s dynamic environment.</p><p>We believe that success extends beyond technical expertise; it also requires a strong foundation in leadership and teamwork. By emphasizing the development of a mindset that fosters collaboration, adaptability, and innovation, we prepare our participants to thrive in various situations.</p><p>Through personalized mentorship, participants gain invaluable insights from experienced professionals who guide them on their journey. Our robust industry connections open doors to networking opportunities, internships, and career pathways that significantly enhance their prospects. Additionally, we provide access to the latest technologies and resources, ensuring that our participants are well-prepared to navigate the evolving landscape of their respective fields. At 1000 Hills, we are committed to nurturing the next generation of leaders who are not only skilled but also socially responsible, inspiring them to rise to new heights and make meaningful contributions to their communities while driving positive change in the world around them.</p>',
                    ],
                    [
                        'title' => 'From Grassroots to Greatness: Program Structure and Pathways',
                        'content' => '<p>At 1000 Hills Rugby, our program is meticulously designed to elevate individuals from grassroots beginnings to the pinnacle of their potential in rugby. The journey begins with foundational training that focuses on essential skills, followed by strategic development practices and advanced techniques tailored specifically to the sport.</p><p>Participants engage in rigorous training sessions, learning from experienced coaches who provide guidance and support. This comprehensive approach ensures that individuals not only develop their athletic abilities but also gain a deep understanding of the game.</p><p>As participants progress through the program, they have the opportunity to apply their skills in real-world scenarios, preparing them for competitive play and leadership roles within the sport. By the end of the program, individuals emerge as well-rounded athletes, equipped with the knowledge and experience necessary to excel on the field and contribute positively to their teams and communities. At 1000 Hills, we are committed to fostering the next generation of rugby leaders, guiding them on their journey from grassroots to greatness.</p>',
                    ],
                    [
                        'title' => 'Join the Team: Application Process',
                        'content' => '<p>Are you ready to take the next step and become a part of the 1000 Hills Rugby family? We invite you to apply through our website by completing the application form with your personal details and rugby experience.</p><p>This is your opportunity to join a community that values teamwork, dedication, and growth in the sport. Once you submit your application, our team will carefully review it and reach out to you to discuss the exciting next steps in your journey with us.</p><p>Don’t miss your chance to join a premier rugby team that is committed to developing talent and fostering a supportive environment. Complete the application form today and prepare to make your mark on the field! We look forward to welcoming you to 1000 Hills Rugby, where your passion for the game can flourish and your skills can reach new heights.</p>',
                    ],
                ],
                'meta_title' => 'About 1000 Hills Rugby | Empowering Communities Through Sport',
                'meta_description' => 'Learn about the journey of 1000 Hills Rugby, our mission, vision, core values, milestones and community impact since 2014.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Programs',
                'slug' => 'academy',
                'subtitle' => 'Helping you grow with tailored training at 1000 Hills Rugby.',
                'hero_image' => 'uploads/1740072895_1hr_Team.JPG',
                'excerpt' => 'From grassroots rugby to high-performance pathways, our programs help players grow on and off the field.',
                'body' => $academyBody,
                'sections' => null,
                'meta_title' => 'Rugby Programs at 1000 Hills Rugby',
                'meta_description' => 'Explore the Player Development, Women’s Rugby, Rugby & Life Skills and Grassroots Rugby programs at 1000 Hills Rugby.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Our Community',
                'slug' => 'community',
                'subtitle' => 'Discover the heart of 1000 Hills Rugby—where youth, families, and partners grow through sport, learning, and connection.',
                'hero_image' => 'images/allmember1.jpg',
                'excerpt' => 'Join the 1000 Hills Rugby community of rugby enthusiasts, athletes, and learners.',
                'body' => $communityBody,
                'sections' => null,
                'meta_title' => 'Our Community | 1000 Hills Rugby',
                'meta_description' => 'Discover the 1000 Hills Rugby community: belonging, rugby skills, family time, life skills and opportunities for young people in Rwanda.',
                'sort_order' => 3,
            ],
            [
                'title' => '1000 Hills Rugby Education Program',
                'slug' => 'education',
                'subtitle' => 'Empowering young girls and boys by providing them with educational opportunities that can transform their lives.',
                'hero_image' => 'images/study.jpg',
                'excerpt' => 'We seek to eliminate the barriers that prevent young rugby players from continuing their education.',
                'body' => $educationBody,
                'sections' => null,
                'meta_title' => 'Education Program | 1000 Hills Rugby',
                'meta_description' => 'Learn how the 1000 Hills Rugby Education Program supports young players with school fees, learning materials and mentorship.',
                'sort_order' => 4,
            ],
            [
                'title' => '1000 Hills Rugby Career Guidance Program',
                'slug' => 'foundation',
                'subtitle' => 'Empowering youth through rugby and career development.',
                'hero_image' => 'images/futureKids.jpg',
                'excerpt' => 'Combining sports training with essential life skills for a brighter future.',
                'body' => $foundationBody,
                'sections' => null,
                'meta_title' => 'Career Guidance Program | 1000 Hills Rugby',
                'meta_description' => 'The 1000 Hills Rugby Career Guidance Program equips young people with life skills, job readiness and entrepreneurship training.',
                'sort_order' => 5,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'subtitle' => 'Effective Date: November 18th, 2024',
                'hero_image' => 'images/aboutImage.jpeg',
                'excerpt' => 'How 1000 Hills Rugby collects, uses and protects your personal information.',
                'body' => $privacyBody,
                'sections' => null,
                'meta_title' => 'Privacy Policy | 1000 Hills Rugby',
                'meta_description' => 'Read the 1000 Hills Rugby privacy policy and learn how we collect, use and protect your personal information.',
                'sort_order' => 6,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page + ['is_published' => true]);
        }
    }
}
