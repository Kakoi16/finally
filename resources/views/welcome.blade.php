<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luminous Events - Premium Event Organizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="min-h-screen text-white">
    <!-- Navigation -->
    <nav class="glass-nav fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <span class="text-xl font-bold">Luminous Events</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium bg-white bg-opacity-10">Home</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Events</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Services</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Gallery</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Contact</a>
                    </div>
                </div>
                <div class="md:hidden">
                    <button class="mobile-menu-button p-2 rounded-md hover:bg-white hover:bg-opacity-10">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="glass-card rounded-2xl p-8 md:p-12">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="md:w-1/2">
                        <h1 class="text-4xl md:text-5xl font-bold mb-4">Create Unforgettable Events</h1>
                        <p class="text-lg mb-8 opacity-90">We design and execute extraordinary events that leave lasting impressions. From corporate gatherings to dream weddings.</p>
                        <div class="flex space-x-4">
                            <button class="bg-white text-purple-700 px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition duration-300">Book a Consultation</button>
                            <button class="border border-white px-6 py-3 rounded-lg font-medium hover:bg-white hover:bg-opacity-10 transition duration-300">View Portfolio</button>
                        </div>
                    </div>
                    <div class="hidden md:block md:w-2/5 mt-8 md:mt-0">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Event setup" class="rounded-xl shadow-xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Our Premium Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="glass-card rounded-2xl p-6 transition duration-300 hover:bg-opacity-20">
                    <div class="bg-white bg-opacity-20 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Event Planning</h3>
                    <p class="opacity-90">Complete event design and coordination from concept to execution, ensuring every detail is perfect.</p>
                </div>
                
                <!-- Service 2 -->
                <div class="glass-card rounded-2xl p-6 transition duration-300 hover:bg-opacity-20">
                    <div class="bg-white bg-opacity-20 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Venue Sourcing</h3>
                    <p class="opacity-90">Access to exclusive venues and relationships with top locations to find the perfect setting for your event.</p>
                </div>
                
                <!-- Service 3 -->
                <div class="glass-card rounded-2xl p-6 transition duration-300 hover:bg-opacity-20">
                    <div class="bg-white bg-opacity-20 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Entertainment</h3>
                    <p class="opacity-90">Curated selection of performers, DJs, bands, and unique entertainment options to wow your guests.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Events -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold">Upcoming Events</h2>
                <a href="#" class="text-sm font-medium hover:underline">View All Events →</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Event 1 -->
                <div class="glass-card rounded-2xl overflow-hidden event-card transition duration-300">
                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Concert event" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-white bg-opacity-20 text-xs px-3 py-1 rounded-full">Music</span>
                            <span class="text-sm opacity-80">June 15, 2023</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Summer Beats Festival</h3>
                        <p class="text-sm opacity-90 mb-4">Join us for the biggest music festival of the summer featuring top international artists.</p>
                        <button class="w-full bg-white text-purple-700 py-2 rounded-lg font-medium hover:bg-opacity-90 transition duration-300">Get Tickets</button>
                    </div>
                </div>
                
                <!-- Event 2 -->
                <div class="glass-card rounded-2xl overflow-hidden event-card transition duration-300">
                    <img src="https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Corporate event" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-white bg-opacity-20 text-xs px-3 py-1 rounded-full">Business</span>
                            <span class="text-sm opacity-80">July 5, 2023</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Tech Innovators Summit</h3>
                        <p class="text-sm opacity-90 mb-4">A gathering of industry leaders to discuss the future of technology and innovation.</p>
                        <button class="w-full bg-white text-purple-700 py-2 rounded-lg font-medium hover:bg-opacity-90 transition duration-300">Register Now</button>
                    </div>
                </div>
                
                <!-- Event 3 -->
                <div class="glass-card rounded-2xl overflow-hidden event-card transition duration-300">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Wedding event" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-white bg-opacity-20 text-xs px-3 py-1 rounded-full">Wedding</span>
                            <span class="text-sm opacity-80">August 20, 2023</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Bridal Showcase</h3>
                        <p class="text-sm opacity-90 mb-4">Discover the latest trends in weddings and meet top vendors for your special day.</p>
                        <button class="w-full bg-white text-purple-700 py-2 rounded-lg font-medium hover:bg-opacity-90 transition duration-300">Learn More</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">What Our Clients Say</h2>
            <div class="glass-card rounded-2xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-white bg-opacity-10 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah Johnson" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold">Sarah Johnson</h4>
                                <p class="text-sm opacity-80">Wedding Client</p>
                            </div>
                        </div>
                        <p class="opacity-90">"Luminous Events made our wedding day absolutely magical. Every detail was perfect and they took care of everything so we could just enjoy our special day."</p>
                    </div>
                    
                    <!-- Testimonial 2 -->
                    <div class="bg-white bg-opacity-10 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Michael Chen" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold">Michael Chen</h4>
                                <p class="text-sm opacity-80">Corporate Client</p>
                            </div>
                        </div>
                        <p class="opacity-90">"Our annual conference was flawlessly executed. The team's attention to detail and problem-solving skills were impressive. Highly recommended!"</p>
                    </div>
                    
                    <!-- Testimonial 3 -->
                    <div class="bg-white bg-opacity-10 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Emily Rodriguez" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold">Emily Rodriguez</h4>
                                <p class="text-sm opacity-80">Birthday Party</p>
                            </div>
                        </div>
                        <p class="opacity-90">"The surprise party they organized for my 30th was beyond my wildest dreams. The theme, decor, and entertainment were all spot on!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="glass-card rounded-2xl p-12 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Create Your Dream Event?</h2>
                <p class="text-lg mb-8 max-w-2xl mx-auto opacity-90">Let's discuss how we can bring your vision to life with our expert event planning services.</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <button class="bg-white text-purple-700 px-8 py-3 rounded-lg font-medium hover:bg-opacity-90 transition duration-300">Get Started</button>
                    <button class="border border-white px-8 py-3 rounded-lg font-medium hover:bg-white hover:bg-opacity-10 transition duration-300">Contact Us</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="glass-nav py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Luminous Events</h3>
                    <p class="text-sm opacity-80">Creating unforgettable experiences through exceptional event planning and execution.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm hover:underline opacity-80">Home</a></li>
                        <li><a href="#" class="text-sm hover:underline opacity-80">About Us</a></li>
                        <li><a href="#" class="text-sm hover:underline opacity-80">Services</a></li>
                        <li><a href="#" class="text-sm hover:underline opacity-80">Gallery</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Services</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm hover:underline opacity-80">Weddings</a></li>
                        <li><a href="#" class="text-sm hover:underline opacity-80">Corporate Events</a></li>
                        <li><a href="#" class="text-sm hover:underline opacity-80">Private Parties</a></li>
                        <li><a href="#" class="text-sm hover:underline opacity-80">Conferences</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="text-sm opacity-80">123 Event Street, Suite 100</li>
                        <li class="text-sm opacity-80">New York, NY 10001</li>
                        <li class="text-sm opacity-80">info@luminousevents.com</li>
                        <li class="text-sm opacity-80">(555) 123-4567</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white border-opacity-20 mt-12 pt-8 text-center text-sm opacity-80">
                <p>© 2023 Luminous Events. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle functionality would go here
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            // Toggle mobile menu
        });
    </script>
</body>
</html>