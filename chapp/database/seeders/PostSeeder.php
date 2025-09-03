<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comments;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user if none exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password'),
            ]
        );

        // Create sample posts
        $posts = [
            [
                'title' => 'Welcome to Chapp - Your Professional Network',
                'description' => 'I\'m excited to share that we\'ve launched Chapp, a new professional networking platform inspired by LinkedIn. This platform allows you to connect with professionals, share insights, and build meaningful relationships in your industry. Join me in exploring this new space for professional growth and networking opportunities!',
                'image_url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'user_id' => $user->id,
            ],
            [
                'title' => 'The Future of Remote Work',
                'description' => 'After working remotely for over 3 years, I\'ve learned some valuable lessons about productivity, communication, and work-life balance. The key is establishing clear boundaries, using the right tools, and maintaining regular communication with your team. What are your thoughts on the future of remote work?',
                'image_url' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'user_id' => $user->id,
            ],
            [
                'title' => 'Building a Strong Professional Network',
                'description' => 'Networking isn\'t just about collecting business cards or LinkedIn connections. It\'s about building genuine relationships based on mutual value and trust. Here are some strategies that have worked for me: 1) Be authentic in your interactions, 2) Offer value before asking for anything, 3) Follow up consistently, and 4) Stay engaged with your network. What networking strategies have worked best for you?',
                'image_url' => null,
                'user_id' => $user->id,
            ],
            [
                'title' => 'Tech Industry Trends 2024',
                'description' => 'The technology landscape continues to evolve rapidly. From AI and machine learning to blockchain and quantum computing, we\'re seeing unprecedented innovation. The key is to stay curious, keep learning, and adapt to new technologies while maintaining a strong foundation in core principles. Which technology trends are you most excited about this year?',
                'image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'user_id' => $user->id,
            ],
            [
                'title' => 'Leadership Lessons from Startup Experience',
                'description' => 'Leading a startup teaches you lessons that no business school can. You learn to make decisions with incomplete information, pivot quickly when needed, and build a culture that can adapt to change. The most important lesson? Your team is everything. Invest in people, not just processes. What leadership lessons have shaped your career?',
                'image_url' => null,
                'user_id' => $user->id,
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::create($postData);
            
            // Add some sample comments to some posts
            if (rand(0, 1)) {
                $commentCount = rand(1, 4);
                for ($i = 0; $i < $commentCount; $i++) {
                    Comments::create([
                        'body' => $this->getSampleComment(),
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                    ]);
                }
            }
        }
    }

    private function getSampleComment(): string
    {
        $comments = [
            'Great insights! Thanks for sharing.',
            'I completely agree with your perspective on this.',
            'This is very helpful information. Looking forward to more posts like this.',
            'Interesting point of view. I hadn\'t considered this angle before.',
            'Thanks for the valuable content. Keep it up!',
            'I\'ve had similar experiences. This resonates with me.',
            'Excellent post! Very informative and well-written.',
            'This is exactly what I needed to read today. Thank you!',
        ];

        return $comments[array_rand($comments)];
    }
}